module.exports = {
    apps: [
        {
            name: "speurtocht-backend",
            cwd: "~/www/speurtocht/backend/",
            script: "npm",
            args: ["run", "start"],
            node_args: [],
            log_date_format: "YYYY_MM_DD HH:mm:ss Z",
            exec_interpreter: "",
            exec_mode: "fork",
            watch: ["./**"],
            autorestart: true,
            vizion: true,
        },
    ],
}