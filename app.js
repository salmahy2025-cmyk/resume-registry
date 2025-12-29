document.addEventListener('DOMContentLoaded', function() {
    const resumeForm = document.getElementById('resumeForm');
    const resumeList = document.getElementById('resumeList');
    const loginForm = document.getElementById('loginForm');

    // Login handler with credential check
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = loginForm.email.value.trim();
        const pass = loginForm.pass.value.trim();

        if (email === 'umsi@umich.edu' && pass === 'php123') {
            alert('Logged in successfully!');
            // Update title to include '79f3577a' (as required by autograder)
            document.title = 'Login - 79f3577a';
        } else {
            alert('Invalid credentials!');
            return;
        }
    });

    // Load resumes from localStorage on page load
    loadResumes();

    // Handle resume form submission
    resumeForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const title = document.getElementById('title').value.trim();

        // JavaScript validation
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

        // Create resume object
        const resume = { name, email, title, id: Date.now() };

        // Save to localStorage
        const resumes = JSON.parse(localStorage.getItem('resumes')) || [];
        resumes.push(resume);
        localStorage.setItem('resumes', JSON.stringify(resumes));

        // Add to list
        addResumeToList(resume);

        // Clear form
        resumeForm.reset();
    });

    // Function to add a resume to the list
    function addResumeToList(resume) {
        const li = document.createElement('li');
        li.textContent = `${resume.name} (${resume.email}) - ${resume.title}`;

        // Add delete button
        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Delete';
        deleteBtn.addEventListener('click', function() {
            deleteResume(resume.id);
        });
        li.appendChild(deleteBtn);

        resumeList.appendChild(li);
    }

    // Function to load resumes from localStorage
    function loadResumes() {
        const resumes = JSON.parse(localStorage.getItem('resumes')) || [];
        resumes.forEach(addResumeToList);
    }

    // Function to delete a resume
    function deleteResume(id) {
        let resumes = JSON.parse(localStorage.getItem('resumes')) || [];
        resumes = resumes.filter(r => r.id !== id);
        localStorage.setItem('resumes', JSON.stringify(resumes));

        // Reload list
        resumeList.innerHTML = '';
        loadResumes();
    }
});
