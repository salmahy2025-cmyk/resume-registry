// "Tables"
let users = JSON.parse(localStorage.getItem("users")) || [];
let resumes = JSON.parse(localStorage.getItem("resumes")) || [];

// CREATE + validation JS
document.getElementById("resumeForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let title = document.getElementById("title").value.trim();

    // Validation navigateur (exigée)
    if (name === "" || email === "" || title === "") {
        alert("All fields are required");
        return;
    }

    if (!email.includes("@")) {
        alert("Invalid email address");
        return;
    }

    // CREATE user (table users)
    let userId = Date.now();
    users.push({
        id: userId,
        name: name,
        email: email
    });

    // CREATE resume (table resumes + clé étrangère user_id)
    resumes.push({
        id: Date.now(),
        user_id: userId,
        title: title
    });

    localStorage.setItem("users", JSON.stringify(users));
    localStorage.setItem("resumes", JSON.stringify(resumes));

    displayResumes();
    document.getElementById("resumeForm").reset();
});

// READ
function displayResumes() {
    let list = document.getElementById("resumeList");
    list.innerHTML = "";

    resumes.forEach((r, index) => {
        let user = users.find(u => u.id === r.user_id);

        let li = document.createElement("li");
        li.innerHTML = `
            ${user.name} (${user.email}) - ${r.title}
            <button onclick="deleteResume(${index})">Delete</button>
        `;
        list.appendChild(li);
    });
}

// DELETE
function deleteResume(index) {
    resumes.splice(index, 1);
    users.splice(index, 1);

    localStorage.setItem("users", JSON.stringify(users));
    localStorage.setItem("resumes", JSON.stringify(resumes));

    displayResumes();
}

// Initial read
displayResumes();
