document.addEventListener('DOMContentLoaded', function() {
    const resumeForm = document.getElementById('resumeForm');
    const resumeList = document.getElementById('resumeList');

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
