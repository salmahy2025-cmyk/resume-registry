document.addEventListener('DOMContentLoaded', function() {
    const resumeForm = document.getElementById('resumeForm');
    const resumeList = document.getElementById('resumeList');
    const loginForm = document.getElementById('loginForm');

    // Login handler
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = loginForm.email.value.trim();
            const pass = loginForm.pass.value.trim();

            if (email === 'umsi@umich.edu' && pass === 'php123') {
                alert('Logged in successfully!');
                document.title = 'Login - 79f3577a';
                // Rediriger vers la page Add
                window.location.href = 'add.html';
            } else {
                alert('Invalid credentials!');
                return;
            }
        });
    }

    // Resume form handler
    if (resumeForm) {
        loadResumes();

        resumeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const title = document.getElementById('title').value.trim();

            // Validation
            if (!name) {
                alert('Name is required.');
                return;
            }
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('A valid email is required.');
                return;
            }
            if (!title) {
                alert('Title is required.');
                return;
            }

            const resume = { name, email, title, id: Date.now() };
            const resumes = JSON.parse(localStorage.getItem('resumes')) || [];
            resumes.push(resume);
            localStorage.setItem('resumes', JSON.stringify(resumes));

            addResumeToList(resume);
            resumeForm.reset();
        });
    }

    // Functions
    function addResumeToList(resume) {
        const li = document.createElement('li');
        li.textContent = `${resume.name} (${resume.email}) - ${resume.title}`;

        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Delete';
        deleteBtn.addEventListener('click', function() {
            deleteResume(resume.id);
        });
        li.appendChild(deleteBtn);

        resumeList.appendChild(li);
    }

    function loadResumes() {
        const resumes = JSON.parse(localStorage.getItem('resumes')) || [];
        resumes.forEach(addResumeToList);
    }

    function deleteResume(id) {
        let resumes = JSON.parse(localStorage.getItem('resumes')) || [];
        resumes = resumes.filter(r => r.id !== id);
        localStorage.setItem('resumes', JSON.stringify(resumes));

        resumeList.innerHTML = '';
        loadResumes();
    }
});
