module.exports = {
    apps: [
        {
            name: "todo-app",
            cwd: "~/www/speurtocht/backend/",
            script: "npm",
            args: ["run", "start"],
            node_args: [],
            log_date_format: "YYYY_MM_DD HH:mm:ss Z",
            exec_interpreter: "",
            exec_mode: "fork",
            watch: ["src/**"],
            autorestart: true,
            vizion: true,
        },
    ],
}