document.querySelectorAll("td.field-boolean input[type=checkbox]").forEach((node) =>
  node.addEventListener("click", () => location.reload())
)

