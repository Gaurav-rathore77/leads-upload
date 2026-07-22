import fs from "fs";
import csv from "csv-parser";
import axios from "axios";
import pLimit from "p-limit";

const API_URL = "https://api-gate.admitnation.ai/lead/capture/pub";

const SECRET_KEY =
  "15653824937228a04950475386c4d12578fe98d6ab7a4889a394691048698f29";

// Increase if API allows more traffic
const CONCURRENT_REQUESTS = 20;

const limit = pLimit(CONCURRENT_REQUESTS);

let success = 0;
let failed = 0;
const failedLeads = [];

const axiosInstance = axios.create({
  baseURL: API_URL,
  timeout: 120000,
  headers: {
    "Content-Type": "application/json",
    accept: "*/*",
    "x-secret-key": SECRET_KEY,
  },
});
// fix the issue here 
function createPayload(row) {
  return {
    firstname: row.FirstName?.trim(),
    // lastname: row.LastName?.trim() || "",

    mcc: 91,
    mobile: String(row.Mobile).replace(/\D/g, ""),
    email: row.Email?.trim().toLowerCase(),

    gender: row.Gender?.trim() || "Male",

    interest: {
  institution: "",

  stream: "Engineering",
  degree: "Under Graduate",
  course: "Bachelor of Technology",

  // specialization: row.Specialization?.trim() || "",

  modeofstudy: "Full Time",
  budget: Number(row.Budget) || 0,

  prefcountry: "India",
  prefstate: row.State?.trim() || "",
  prefcity: row.City?.split(",")[0].trim() || "",
},

    tracking: {
      utm_channel: "Online",
      utm_source: "google adwords",
      utm_campaign: "Lead Upload",
      utm_medium: "",
    },
  };
}

async function uploadLead(payload, retries = 3) {
  try {
    console.log("\n===== PAYLOAD =====");
    console.log(JSON.stringify(payload, null, 2));
    console.log("===================\n");

    const response = await axiosInstance.post("", payload);

    console.log("HTTP Status:", response.status);
    console.dir(response.data, { depth: null });

    const { code, message } = response.data;

    // Success Codes
    const SUCCESS_CODES = ["SUCCESS", "LEAD_CAPTURED"];

    if (!SUCCESS_CODES.includes(code)) {
      throw {
        type: "BUSINESS",
        message,
        code,
      };
    }

    success++;

    console.log(`SUCCESS : ${payload.email}`);
    console.log("Business Code :", code);
    console.log("Message       :", message);
    console.log("========================================\n");

    return true;
  } catch (err) {
    console.log("\n========================================");
    console.log(`FAILED : ${payload.email}`);


    // "ahsdfhafhadsifhadsi?"
    // -------------------------------
    // Business Error
    // -------------------------------
    if (err.type === "BUSINESS") {
      console.log("Business Code :", err.code);
      console.log("Message       :", err.message);

      failed++;

      failedLeads.push({
        payload,
        code: err.code,
        error: err.message,
      });

      console.log("========================================\n");

      return false;
    }

    
    if (err.response) {
      console.log("HTTP Status :", err.response.status);
      console.dir(err.response.data, { depth: null });

      // Retry only for 5xx
      if (retries > 0 && err.response.status >= 500) {
        console.log(
          `Retrying ${payload.email} (${4 - retries}/3)...`
        );

        await new Promise((r) =>
          setTimeout(r, (4 - retries) * 2000)
        );

        return uploadLead(payload, retries - 1);
      }

      failed++;

      failedLeads.push({
        payload,
        status: err.response.status,
        error: err.response.data,
      });

      console.log("========================================\n");

      return false;
    }

    // -------------------------------
    // Network Error
    // -------------------------------
    console.log("Network Error :", err.code);
    console.log(err.message);

    if (retries > 0) {
      console.log(
        `Retrying ${payload.email} (${4 - retries}/3)...`
      );

      await new Promise((r) =>
        setTimeout(r, (4 - retries) * 2000)
      );

      return uploadLead(payload, retries - 1);
    }

    failed++;

    failedLeads.push({
      payload,
      error: err.message,
    });

    console.log("========================================\n");

    return false;
  }
}
async function main() {
  const tasks = [];

  fs.createReadStream("data.csv")
    .pipe(csv())
    .on("data", (row) => {
      if (!row.Email || !row.Mobile) return;

      const payload = createPayload(row);

      tasks.push(
        limit(() => uploadLead(payload))
      );
    })
    .on("end", async () => {
      console.log(`\nUploading ${tasks.length} Leads...\n`);

      await Promise.all(tasks);

      if (failedLeads.length) {
        fs.writeFileSync(
          "failed_leads.json",
          JSON.stringify(failedLeads, null, 2)
        );
      }

      console.log("\n==============================");
      console.log("UPLOAD FINISHED");
      console.log("==============================");
      console.log(`Success : ${success}`);
      console.log(`Failed  : ${failed}`);

      if (failedLeads.length) {
        console.log("failed_leads.json created");
      }
    });
}

main();