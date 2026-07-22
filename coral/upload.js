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

    console.log("\n========== Upload Started ==========\n");
    console.log(`Total Leads : ${leads.length}\n`);

    let success = 0;

    for (let i = 0; i < leads.length; i++) {

      const lead = leads[i];

      console.log("\n====================================");
      console.log(`Lead ${i + 1}/${leads.length}`);
      console.log("Customer :", lead["Customer Name"]);
      console.log("Payload :", JSON.stringify(lead, null, 2));
      console.log("====================================");

      try {

        // ===========================
        // SalesMax
        // ===========================
        const salesmax = await axios.post(
          process.env.SALESMAX_API,
          lead,
          {
            headers: {
              "Content-Type": "application/json"
            },
            timeout: 30000,
            validateStatus: () => true
          }
        );

        console.log("\n------ SalesMax ------");
        console.log("Status :", salesmax.status);
        console.log("Response :", JSON.stringify(salesmax.data, null, 2));

        if (
          salesmax.status < 200 ||
          salesmax.status >= 300 ||
          salesmax.data?.success === false
        ) {
          throw new Error(
            salesmax.data?.message || "SalesMax Upload Failed"
          );
        }

        // ===========================
        // Google Sheet
        // ===========================
        const sheet = await axios.post(
          process.env.GOOGLE_SHEET_API,
          lead,
          {
            headers: {
              "Content-Type": "application/json"
            },
            timeout: 30000,
            validateStatus: () => true
          }
        );

        console.log("\n------ Google Sheet ------");
        console.log("Status :", sheet.status);
        console.log("Response :", JSON.stringify(sheet.data, null, 2));

        if (
          sheet.status < 200 ||
          sheet.status >= 300 ||
          sheet.data?.success === false
        ) {
          throw new Error(
            sheet.data?.message || "Google Sheet Upload Failed"
          );
        }

        success++;

        console.log(`\n SUCCESS : ${lead["Customer Name"]}`);

      } catch (err) {

        console.log(`\n FAILED : ${lead["Customer Name"]}`);

        console.log("Message :", err.message);

        if (err.response) {
          console.log("Status :", err.response.status);
          console.log("Response :", err.response.data);
        }

        failed.push({
          lead,
          error: err.message,
          status: err.response?.status || null,
          response: err.response?.data || null
        });

      }
      // 'ajfadfs??

      await new Promise(resolve => setTimeout(resolve, 1000));

    }

    fs.writeFileSync(
      "failed_leads.json",
      JSON.stringify(failed, null, 2)
    );

    console.log("\n====================================");
    console.log(`Total Leads : ${leads.length}`);
    console.log(`Success     : ${success}`);
    console.log(`Failed      : ${failed.length}`);
    console.log("====================================");

  });