document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');
    const sidebarLinks = sidebar.querySelectorAll('a');

    // Function to collapse the sidebar
    const collapseSidebar = () => {
        if (sidebar.classList.contains('expanded')) {
            sidebar.classList.remove('expanded');
        }
    };

    // Toggle sidebar on hamburger click
    hamburger.addEventListener('click', (e) => {
        e.stopPropagation();  // Prevent event from propagating to document
        sidebar.classList.toggle('expanded');
    });

    // Collapse sidebar if clicking outside of it
    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
            collapseSidebar();
        }
    });

    // Collapse sidebar when clicking inside the sidebar links
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            collapseSidebar();
        });
    });

    // Prevent sidebar from closing when clicking inside of it
    sidebar.addEventListener('click', (e) => {
        e.stopPropagation();
    });
});
