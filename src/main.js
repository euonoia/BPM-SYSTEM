document.addEventListener("DOMContentLoaded", () => {
    const root = document.getElementById("root") || createRoot();

    root.innerHTML = "<p>Hello from src/main.js!</p>";
});

function createRoot() {
    const root = document.createElement("div");
    root.id = "root";
    document.body.appendChild(root);
    return root;
}
