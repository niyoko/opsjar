import { deploy, excludeDefaults } from "@samkirkland/ftp-deploy";

async function deployMyCode() {
  console.log("🚚 Deploy started");
  await deploy({
    server: "ftp.opsjar.site",
    username: "git@opsjar.site",
    password: `ZkW34fMg2fKEbf6cwDDPt7pr`,
    exclude: [
      ...excludeDefaults,
      "_protected/common/config/main-local.php",
      "_protected/backend/config/main-local.php",
      "_protected/backend/web/assets/**",
      "assets/**",
      "deploy.js",
    ],
  });
  console.log("🚀 Deploy done!");
}

deployMyCode();
