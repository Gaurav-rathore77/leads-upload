import fs from "fs";
import csv from "csv-parser";
import axios from "axios";
import pLimit from "p-limit";

const API_URL = "https://ruseducation.co/leads-api";

const BATCH_SIZE = 50;
const CONCURRENT_REQUESTS = 5;

const limit = pLimit(CONCURRENT_REQUESTS);

let batch = [];
let promises = [];

async function uploadBatch(batchData) {
  try {
    await Promise.all(
      batchData.map((row) =>
        limit(() =>
          axios.post(API_URL, {
            Name: row.Name,
            Email: row.Email,
            PhoneNo: row.PhoneNo,
            State: row.State,
            City: row.City,
          })
        )
      )
    );

    console.log(`✅ Batch uploaded: ${batchData.length}`);
  } catch (err) {
    console.log("❌ Batch error:", err.message);
  }
}

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

    console.log("All data uploaded!");
  });  