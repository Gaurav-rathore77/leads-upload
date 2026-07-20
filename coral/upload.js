import fs from "fs";
import csv from "csv-parser";
import axios from "axios";
import dotenv from "dotenv";

dotenv.config();

const leads = [];
const failed = [];

fs.createReadStream("data.csv")
  .pipe(csv())
  .on("data", (row) => leads.push(row))
  .on("end", async () => {

    console.log(`\n========== Upload Started ==========\n`);
    console.log(`Total Leads : ${leads.length}\n`);

    let success = 0;

    for (let i = 0; i < leads.length; i++) {

      const lead = leads[i];

      try {

        // ===============================
        // SalesMax
        // ===============================
        const salesmax = await axios.post(
          process.env.SALESMAX_API,
          lead,
          {
            headers: {
              "Content-Type": "application/json"
            },
            validateStatus: () => true
          }
        );

        console.log(`SalesMax : ${salesmax.status}`);

        if (salesmax.status < 200 || salesmax.status >= 300) {
          throw new Error("SalesMax Upload Failed");
        }

        // ===============================
        // Google Sheet
        // ===============================
        const sheet = await axios.post(
          process.env.GOOGLE_SHEET_API,
          lead,
          {
            headers: {
              "Content-Type": "application/json"
            },
            maxRedirects: 5,
            validateStatus: () => true
          }
        );

        console.log(`Google Sheet : ${sheet.status}`);
        console.log("Google Response :", sheet.data);

        if (sheet.status < 200 || sheet.status >= 300) {
          throw new Error("Google Sheet Upload Failed");
        }

        console.log(`✅ ${i + 1}/${leads.length} ${lead["Customer Name"]}`);

        success++;

      } catch (err) {

        console.log(`❌ ${i + 1}/${leads.length} ${lead["Customer Name"]}`);

        console.log(err.message);

        failed.push({
          lead,
          error: err.message
        });

      }

      await new Promise(r => setTimeout(r, 1000));

    }

    fs.writeFileSync(
      "failed_leads.json",
      JSON.stringify(failed, null, 2)
    );

    console.log("\n==============================");
    console.log(`Success : ${success}`);
    console.log(`Failed  : ${failed.length}`);
    console.log("==============================");

  });