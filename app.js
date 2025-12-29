document.addEventListener('DOMContentLoaded', function() {
    const resumeForm = document.getElementById('resumeForm');
    const resumeList = document.getElementById('resumeList');
    const loginForm = document.querySelector('form[method="post"]');

    // Dummy login handler
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Logged in successfully!');

        // Update title tag dynamically (include name or '79f3577a')
        const name = document.getElementById('name').value.trim() || '79f3577a';  // Use name from form or fallback
        document.title = `Login - ${name}`;
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
