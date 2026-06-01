import fs from "fs";
import csv from "csv-parser";
import axios from "axios";
import pLimit from "p-limit";

const API_URL =
  "https://crm.reviewadda.com/leadsPanel/api/create-student";


const API_KEY = "VidhyaV_2026";
const SOURCE_ID = "80";


const BATCH_SIZE = 50;
const CONCURRENT_REQUESTS = 5;
const RETRY_COUNT = 3;

const limit = pLimit(CONCURRENT_REQUESTS);

let batch = [];
let promises = [];


async function retryRequest(payload, retries = RETRY_COUNT) {
  try {
    const response = await axios.post(API_URL, payload, {
      headers: {
        "Content-Type": "application/json",
      },
    });

    console.log(`Success: ${payload.email}`);

    return true;
  } catch (err) {
    console.log(`Error for ${payload.email}`);

    if (err.response) {
      console.log("STATUS:", err.response.status);
      console.log("DATA:", err.response.data);
    } else {
      console.log(err.message);
    }

    if (retries > 0) {
      console.log(`Retrying ${payload.email}...`);
      return retryRequest(payload, retries - 1);
    }

    return false;
  }
}

// Upload batch
async function uploadBatch(batchData) {
  try {
    await Promise.all(
      batchData.map((row) =>
  limit(() =>
    retryRequest({
      key: API_KEY,

      name: row.Name?.trim(),

      email: row.Email?.toLowerCase().trim(),

      phone: row.PhoneNo
        ?.replace("p:+91", "")
        ?.replace("p:+", "")
        ?.replace("p:", "")
        ?.replace(/\D/g, "")
        ?.trim(),

      clg_id:
        row.College?.trim() ||
        "Lovely Professional",

      course:
        row.Course?.trim() ||
        "B.Tech",

      dob:
        row.DOB?.trim() ||
        "2000-01-01",

      qualification:
        row.Qualification?.trim() ||
        "12th",

      city: row.City?.trim(),

      source_id: SOURCE_ID,

      state: row.State?.trim(),
    })
  )
)
    );

    console.log(
      `Batch Uploaded: ${batchData.length}`
    );
  } catch (err) {
    console.log("Batch Error:", err.message);
  }
}

// Read CSV
fs.createReadStream("data.csv")
  .pipe(csv())
  .on("data", (row) => {
    // Basic validation
    if (!row.Email || !row.PhoneNo || !row.Name) {
      console.log("Skipped invalid row");
      return;
    }

    batch.push(row);

    if (batch.length >= BATCH_SIZE) {
      promises.push(uploadBatch(batch));
      batch = [];
    }
  })
  .on("end", async () => {
    // Remaining batch
    if (batch.length > 0) {
      promises.push(uploadBatch(batch));
    }

    await Promise.all(promises);

    console.log(
      "All leads uploaded successfully!"
    );
  });