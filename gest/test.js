import fs from "fs";
import csv from "csv-parser";
import axios from "axios";
import pLimit from "p-limit";

const API_URL =
  "https://crm.reviewadda.com/leadsPanel/api/create-student";

// YOUR CONSTANTS
const FIXED_KEY = "VidhyaV_2026";
const FIXED_SOURCE_ID = "72";

// CONCURRENT REQUESTS
const CONCURRENT_REQUESTS = 5;

const limit = pLimit(CONCURRENT_REQUESTS);

const tasks = [];

// API REQUEST FUNCTION
async function sendLead(payload, retries = 3) {
  try {
    console.log("=================================");
    console.log("SENDING LEAD:", payload.email);

    const response = await axios.post(
      API_URL,
      payload,
      {
        headers: {
          "Content-Type": "application/json",

          // UPDATE COOKIE IF EXPIRED
          Cookie:
            "JSESSIONID=3E602F2DF50F944B893FFF7711A6899E",
        },

        timeout: 10000,
      }
    );

    console.log("SUCCESS:", payload.email);
    console.log("RESPONSE:", response.data);

    return true;
  } catch (err) {
    console.log("FAILED:", payload.email);

    console.log(
      "STATUS:",
      err.response?.status || "NO STATUS"
    );

    console.log(
      "ERROR:",
      JSON.stringify(err.response?.data, null, 2)
    );

    // RETRY
    if (retries > 0) {
      console.log("RETRYING...");
      return sendLead(payload, retries - 1);
    }

    return false;
  }
}

// READ CSV
fs.createReadStream("data.csv")
  .pipe(csv())

  .on("headers", (headers) => {
    console.log("CSV HEADERS:", headers);
  })

  .on("data", (row) => {
    console.log("ROW:", row);

    // CREATE PAYLOAD
    const payload = {
      key: FIXED_KEY,

      name: row.Name?.trim(),

      phone: row.PhoneNo?.trim(),

      email: row.Email?.trim()?.toLowerCase(),

      clg_id:
        row.College?.trim() ||
        "Lovely Professional",

      course:
        row.Course?.trim() || "B.Tech",

      dob:
        row.DOB?.trim() || "2000-01-01",

      qualification:
        row.Qualification?.trim() ||
        "12th",

      city:
        row.City?.trim() || "Delhi",

      source_id: FIXED_SOURCE_ID,

      state:
        row.State?.trim() || "Delhi",
    };

    console.log("PAYLOAD:", payload);

    // PUSH TASK
    tasks.push(
      limit(() => sendLead(payload))
    );
  })

  .on("end", async () => {
    console.log("=================================");
    console.log("CSV FINISHED");
    console.log("WAITING FOR REQUESTS...");

    // WAIT FOR ALL
    await Promise.all(tasks);

    console.log("=================================");
    console.log("ALL REQUESTS DONE");
  })

  .on("error", (err) => {
    console.log("CSV ERROR:", err.message);
  });