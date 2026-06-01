import fs from "fs";
import csv from "csv-parser";
import axios from "axios";
import pLimit from "p-limit";

const API_URL = "https://crm.ismspune.in/api/generateleads";

//  Common API KEY
const API_KEY = "1EiRzL1lAUuQ49vslwjhyImvMskQ922okn5kXoA3qmMVXLkLwjRC30RPWzkwkhJw";

const BATCH_SIZE = 50;
const CONCURRENT_REQUESTS = 5;

const limit = pLimit(CONCURRENT_REQUESTS);

let batch = [];
let promises = [];

//  Retry function
async function retryRequest(payload, retries = 3) {
  try {
    await axios.post(API_URL, payload, {
      headers: {
        "Content-Type": "application/json",
      },
    });

    console.log("✅ Success:", payload.email);
    return true;

  } catch (err) {
    if (retries > 0) {
      console.log("🔁 Retrying...", payload.email);
      return retryRequest(payload, retries - 1);
    } else {
      console.log("❌ Failed:", payload.email);

      if (err.response) {
        console.log("👉 STATUS:", err.response.status);
        console.log("👉 DATA:", err.response.data);
      }

      return false;
    }
  }
}

// Batch upload
async function uploadBatch(batchData) {
  try {
    await Promise.all(
      batchData.map((row) =>
        limit(() =>
         retryRequest({
  name: row.Name.trim(),
  email: row.Email.toLowerCase().trim(),
  phonenumber: row.PhoneNo.trim(),
  "x-api-key": API_KEY   
})
        )
      )
    );

    console.log(`Batch uploaded: ${batchData.length}`);
  } catch (err) {
    console.log("Batch error:", err.message);
  }
}

// Read CSV
fs.createReadStream("data.csv")
  .pipe(csv())
  .on("data", (row) => {
    if (!row.Email || !row.PhoneNo) return;

    batch.push(row);

    if (batch.length === BATCH_SIZE) {
      promises.push(uploadBatch(batch));
      batch = [];
    }
  })
  .on("end", async () => {
    if (batch.length > 0) {
      promises.push(uploadBatch(batch));
    }

    await Promise.all(promises);

    console.log(" All leads uploaded successfully!");
  });