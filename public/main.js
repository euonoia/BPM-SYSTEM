document.addEventListener("DOMContentLoaded", () => {
    const root = document.getElementById("root") || createRoot();
});

function createRoot() {
    const root = document.createElement("div");
    root.id = "root";
    document.body.appendChild(root);
    return root;
}
