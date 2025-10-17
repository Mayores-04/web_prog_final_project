<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPortal - Learning Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .nav-tabs {
            background: white;
            border-bottom: 2px solid #e0e0e0;
            margin-top: 1rem;
        }

        .nav-tabs-content {
            display: flex;
            gap: 0;
        }

        .nav-tab {
            padding: 1rem 2rem;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            font-weight: 500;
            color: #666;
        }

        .nav-tab:hover {
            background: #f5f5f5;
            color: #1e3c72;
        }

        .nav-tab.active {
            border-bottom-color: #1e3c72;
            color: #1e3c72;
        }

        .main-content {
            padding: 2rem 0;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-icon.green { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .stat-icon.orange { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .stat-icon.purple { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        .stat-info h3 {
            font-size: 2rem;
            color: #1e3c72;
        }

        .stat-info p {
            color: #666;
            font-size: 0.9rem;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        }

        .course-header {
            height: 160px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .course-body {
            padding: 1.5rem;
        }

        .course-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: #1e3c72;
        }

        .course-instructor {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .course-stats {
            display: flex;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            font-size: 0.85rem;
            color: #888;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
            border-radius: 10px;
            transition: width 0.3s;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .assignment-list {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .assignment-item {
            padding: 1.5rem;
            border-left: 4px solid #667eea;
            background: #f8f9fa;
            margin-bottom: 1rem;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .assignment-item:hover {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .assignment-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 0.5rem;
        }

        .assignment-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e3c72;
        }

        .assignment-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-submitted {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-graded {
            background: #d4edda;
            color: #155724;
        }

        .assignment-details {
            color: #666;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .quiz-container {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            max-width: 800px;
        }

        .quiz-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e0e0e0;
        }

        .quiz-title {
            font-size: 1.8rem;
            color: #1e3c72;
            margin-bottom: 0.5rem;
        }

        .quiz-info {
            color: #666;
            font-size: 0.9rem;
        }

        .quiz-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .quiz-card:hover {
            background: white;
            border-color: #667eea;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .quiz-card-title {
            font-size: 1.2rem;
            color: #1e3c72;
            margin-bottom: 1rem;
        }

        .quiz-card-info {
            display: flex;
            gap: 20px;
            color: #666;
            font-size: 0.9rem;
        }

        .grade-table {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: #f8f9fa;
            color: #1e3c72;
            font-weight: 600;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .grade-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .grade-a { background: #d4edda; color: #155724; }
        .grade-b { background: #d1ecf1; color: #0c5460; }
        .grade-c { background: #fff3cd; color: #856404; }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            color: #1e3c72;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    📚 EduPortal
                </div>
                <div class="user-menu">
                    <div class="user-info">
                        <div class="avatar">JD</div>
                        <div>
                            <div style="font-weight: 600;">Juan Dela Cruz</div>
                            <div style="font-size: 0.85rem; opacity: 0.9;">Student</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <nav class="nav-tabs">
        <div class="container">
            <div class="nav-tabs-content">
                <div class="nav-tab active" onclick="showSection('dashboard')">📊 Dashboard</div>
                <div class="nav-tab" onclick="showSection('courses')">📖 My Courses</div>
                <div class="nav-tab" onclick="showSection('assignments')">📝 Assignments</div>
                <div class="nav-tab" onclick="showSection('quizzes')">✅ Quizzes</div>
                <div class="nav-tab" onclick="showSection('grades')">🎯 Grades</div>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        <!-- Dashboard Section -->
        <div class="content-section active" id="dashboard">
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">📚</div>
                    <div class="stat-info">
                        <h3>5</h3>
                        <p>Active Courses</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">✅</div>
                    <div class="stat-info">
                        <h3>12</h3>
                        <p>Completed Assignments</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">⏰</div>
                    <div class="stat-info">
                        <h3>3</h3>
                        <p>Pending Tasks</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">🎯</div>
                    <div class="stat-info">
                        <h3>87%</h3>
                        <p>Average Grade</p>
                    </div>
                </div>
            </div>

            <h2 class="section-title" style="margin-bottom: 1.5rem;">Recent Activity</h2>
            <div class="assignment-list">
                <div class="assignment-item">
                    <div class="assignment-header">
                        <div class="assignment-title">📊 Database Design Quiz Due Tomorrow</div>
                        <span class="assignment-status status-pending">Pending</span>
                    </div>
                    <div class="assignment-details">Information Systems • Due: Oct 18, 2025</div>
                </div>
                <div class="assignment-item">
                    <div class="assignment-header">
                        <div class="assignment-title">📝 Essay: Web Development Best Practices</div>
                        <span class="assignment-status status-submitted">Submitted</span>
                    </div>
                    <div class="assignment-details">Web Programming • Submitted: Oct 16, 2025</div>
                </div>
                <div class="assignment-item">
                    <div class="assignment-header">
                        <div class="assignment-title">💻 PHP CRUD Application Project</div>
                        <span class="assignment-status status-graded">Graded: 92/100</span>
                    </div>
                    <div class="assignment-details">Web Programming • Graded: Oct 15, 2025</div>
                </div>
            </div>
        </div>

        <!-- Courses Section -->
        <div class="content-section" id="courses">
            <div class="section-header">
                <h2 class="section-title">My Courses</h2>
                <button class="btn btn-primary">+ Enroll in Course</button>
            </div>
            <div class="courses-grid">
                <div class="course-card">
                    <div class="course-header">💻</div>
                    <div class="course-body">
                        <h3 class="course-title">Web Programming with PHP</h3>
                        <p class="course-instructor">👨‍🏫 Prof. Maria Santos</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 75%"></div>
                        </div>
                        <div style="text-align: right; font-size: 0.85rem; color: #666; margin-top: 5px;">75% Complete</div>
                        <div class="course-stats">
                            <span>📝 8 Assignments</span>
                            <span>👥 45 Students</span>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">🗄️</div>
                    <div class="course-body">
                        <h3 class="course-title">Database Management Systems</h3>
                        <p class="course-instructor">👨‍🏫 Prof. Roberto Cruz</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 60%"></div>
                        </div>
                        <div style="text-align: right; font-size: 0.85rem; color: #666; margin-top: 5px;">60% Complete</div>
                        <div class="course-stats">
                            <span>📝 10 Assignments</span>
                            <span>👥 52 Students</span>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">🎨</div>
                    <div class="course-body">
                        <h3 class="course-title">UI/UX Design Fundamentals</h3>
                        <p class="course-instructor">👩‍🏫 Prof. Ana Reyes</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 45%"></div>
                        </div>
                        <div style="text-align: right; font-size: 0.85rem; color: #666; margin-top: 5px;">45% Complete</div>
                        <div class="course-stats">
                            <span>📝 6 Assignments</span>
                            <span>👥 38 Students</span>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">🔐</div>
                    <div class="course-body">
                        <h3 class="course-title">Information Security</h3>
                        <p class="course-instructor">👨‍🏫 Prof. Carlos Mendoza</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 85%"></div>
                        </div>
                        <div style="text-align: right; font-size: 0.85rem; color: #666; margin-top: 5px;">85% Complete</div>
                        <div class="course-stats">
                            <span>📝 7 Assignments</span>
                            <span>👥 41 Students</span>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">📊</div>
                    <div class="course-body">
                        <h3 class="course-title">Data Structures & Algorithms</h3>
                        <p class="course-instructor">👩‍🏫 Prof. Linda Garcia</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 55%"></div>
                        </div>
                        <div style="text-align: right; font-size: 0.85rem; color: #666; margin-top: 5px;">55% Complete</div>
                        <div class="course-stats">
                            <span>📝 12 Assignments</span>
                            <span>👥 48 Students</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignments Section -->
        <div class="content-section" id="assignments">
            <h2 class="section-title" style="margin-bottom: 1.5rem;">All Assignments</h2>
            <div class="assignment-list">
                <div class="assignment-item" style="border-left-color: #dc3545;">
                    <div class="assignment-header">
                        <div class="assignment-title">📊 Database Normalization Exercise</div>
                        <span class="assignment-status status-pending">Due Tomorrow</span>
                    </div>
                    <div class="assignment-details">Database Management Systems • Due: Oct 18, 2025 11:59 PM • 50 points</div>
                    <button class="btn btn-primary" style="margin-top: 1rem;">Start Assignment</button>
                </div>

                <div class="assignment-item" style="border-left-color: #ffc107;">
                    <div class="assignment-header">
                        <div class="assignment-title">💻 Create a Login System with Session Management</div>
                        <span class="assignment-status status-pending">Due in 3 days</span>
                    </div>
                    <div class="assignment-details">Web Programming • Due: Oct 20, 2025 11:59 PM • 100 points</div>
                    <button class="btn btn-primary" style="margin-top: 1rem;">Start Assignment</button>
                </div>

                <div class="assignment-item" style="border-left-color: #17a2b8;">
                    <div class="assignment-header">
                        <div class="assignment-title">🎨 Wireframe Design for E-commerce Site</div>
                        <span class="assignment-status status-submitted">Submitted</span>
                    </div>
                    <div class="assignment-details">UI/UX Design • Submitted: Oct 16, 2025 • 75 points</div>
                </div>

                <div class="assignment-item" style="border-left-color: #28a745;">
                    <div class="assignment-header">
                        <div class="assignment-title">🔐 Security Audit Report</div>
                        <span class="assignment-status status-graded">Grade: 95/100</span>
                    </div>
                    <div class="assignment-details">Information Security • Graded: Oct 15, 2025</div>
                </div>

                <div class="assignment-item" style="border-left-color: #28a745;">
                    <div class="assignment-header">
                        <div class="assignment-title">📊 Binary Search Tree Implementation</div>
                        <span class="assignment-status status-graded">Grade: 88/100</span>
                    </div>
                    <div class="assignment-details">Data Structures • Graded: Oct 14, 2025</div>
                </div>
            </div>
        </div>

        <!-- Quizzes Section -->
        <div class="content-section" id="quizzes">
            <h2 class="section-title" style="margin-bottom: 1.5rem;">Available Quizzes</h2>
            <div class="quiz-container">
                <div class="quiz-card" onclick="alert('In the real PHP app, this would start the quiz!')">
                    <div class="quiz-card-title">📊 SQL Queries and Joins - Midterm Quiz</div>
                    <div class="quiz-card-info">
                        <span>⏰ 60 minutes</span>
                        <span>❓ 25 questions</span>
                        <span>📅 Available until: Oct 20, 2025</span>
                    </div>
                </div>

                <div class="quiz-card" onclick="alert('In the real PHP app, this would start the quiz!')">
                    <div class="quiz-card-title">💻 PHP Basics and Syntax</div>
                    <div class="quiz-card-info">
                        <span>⏰ 30 minutes</span>
                        <span>❓ 15 questions</span>
                        <span>📅 Available until: Oct 19, 2025</span>
                    </div>
                </div>

                <div class="quiz-card" style="opacity: 0.6; cursor: not-allowed;">
                    <div class="quiz-card-title">🎨 Design Principles Quiz - Completed ✅</div>
                    <div class="quiz-card-info">
                        <span>Score: 92/100</span>
                        <span>Completed: Oct 15, 2025</span>
                    </div>
                </div>

                <div class="quiz-card" style="opacity: 0.6; cursor: not-allowed;">
                    <div class="quiz-card-title">🔐 Cryptography Fundamentals - Completed ✅</div>
                    <div class="quiz-card-info">
                        <span>Score: 88/100</span>
                        <span>Completed: Oct 13, 2025</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grades Section -->
        <div class="content-section" id="grades">
            <h2 class="section-title" style="margin-bottom: 1.5rem;">My Grades</h2>
            <div class="grade-table">
                <table>
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Assignment/Quiz</th>
                            <th>Score</th>
                            <th>Grade</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Web Programming</td>
                            <td>PHP CRUD Application</td>
                            <td>92/100</td>
                            <td><span class="grade-badge grade-a">A</span></td>
                            <td>Oct 15, 2025</td>
                        </tr>
                        <tr>
                            <td>Information Security</td>
                            <td>Security Audit Report</td>
                            <td>95/100</td>
                            <td><span class="grade-badge grade-a">A</span></td>
                            <td>Oct 15, 2025</td>
                        </tr>
                        <tr>
                            <td>UI/UX Design</td>
                            <td>Design Principles Quiz</td>
                            <td>92/100</td>
                            <td><span class="grade-badge grade-a">A</span></td>
                            <td>Oct 15, 2025</td>
                        </tr>
                        <tr>
                            <td>Data Structures</td>
                            <td>Binary Search Tree</td>
                            <td>88/100</td>
                            <td><span class="grade-badge grade-b">B+</span></td>
                            <td>Oct 14, 2025</td>
                        </tr>
                        <tr>
                            <td>Information Security</td>
                            <td>Cryptography Quiz</td>
                            <td>88/100</td>
                            <td><span class="grade-badge grade-b">B+</span></td>
                            <td>Oct 13, 2025</td>
                        </tr>
                        <tr>
                            <td>Database Management</td>
                            <td>ER Diagram Assignment</td>
                            <td>85/100</td>
                            <td><span class="grade-badge grade-b">B</span></td>
                            <td>Oct 12, 2025</td>
                        </tr>
                        <tr>
                            <td>Web Programming</td>
                            <td>HTML/CSS Midterm</td>
                            <td>78/100</td>
                            <td><span class="grade-badge grade-c">C+</span></td>
                            <td>Oct 10, 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 2rem; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                <h3 style="color: #1e3c72; margin-bottom: 1rem;">Overall Performance</h3>
                <div class="dashboard-grid" style="margin-top: 1rem;">
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; font-weight: bold; color: #11998e;">87%</div>
                        <div style="color: #666;">Average Grade</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; font-weight: bold; color: #667eea;">3.2</div>
                        <div style="color: #666;">GPA</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; font-weight: bold; color: #fa709a;">12</div>
                        <div style="color: #666;">Completed</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; font-weight: bold; color: #4facfe;">3</div>
                        <div style="color: #666;">Pending</div>
                    </div>
                </div>
            </div>
        </div>