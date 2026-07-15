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

    console.log(`Total Leads : ${leads.length}\n`);

    let success = 0;

    for (let i = 0; i < leads.length; i++) {

      const lead = leads[i];

      try {

        const res = await axios.post(
          process.env.SALESMAX_API,
          lead,
          {
            headers: {
              "Content-Type": "application/json"
            }
          }
        );

        console.log(
          `✅ ${i + 1}/${leads.length} ${lead["Customer Name"]}`
        );

        success++;

      } catch (err) {

        console.log(
          `❌ ${i + 1}/${leads.length} ${lead["Customer Name"]}`
        );

        failed.push({
          lead,
          error:
            err.response?.data || err.message
        });

      }

      await new Promise(r => setTimeout(r, 500));

    }

    fs.writeFileSync(
      "failed_leads.json",
      JSON.stringify(failed, null, 2)
    );

    console.log("\n======================");
    console.log(`Success : ${success}`);
    console.log(`Failed  : ${failed.length}`);
    console.log("======================");

  });