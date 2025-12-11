<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Teacher Appraisal is Ready</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #667eea;
            font-weight: bold;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        /* Content */
        .content {
            padding: 30px;
        }

        .greeting {
            margin-bottom: 25px;
        }

        .greeting h2 {
            color: #2d3748;
            font-size: 22px;
            margin-bottom: 10px;
        }

        /* Score Card */
        .score-card {
            background: linear-gradient(135deg, #f6f9fc 0%, #f1f5f9 100%);
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .score-number {
            font-size: 56px;
            font-weight: bold;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .score-grade {
            display: inline-block;
            background-color: #48bb78;
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .score-text {
            color: #4a5568;
            font-size: 16px;
        }

        /* Competencies Grid */
        .competencies-section {
            margin: 30px 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        .competencies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .competency-item {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .competency-name {
            font-size: 13px;
            color: #4a5568;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .competency-score {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748;
        }

        /* Highlights Section */
        .highlights {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .highlight-card {
            padding: 20px;
            border-radius: 10px;
        }

        .strengths-card {
            background-color: #f0fff4;
            border: 1px solid #c6f6d5;
        }

        .improvements-card {
            background-color: #fffaf0;
            border: 1px solid #fed7d7;
        }

        .highlight-title {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 600;
        }

        .strengths-title {
            color: #38a169;
        }

        .improvements-title {
            color: #dd6b20;
        }

        .icon {
            margin-right: 10px;
            font-size: 20px;
        }

        .highlight-list {
            list-style: none;
        }

        .highlight-list li {
            margin-bottom: 10px;
            padding-left: 0;
            position: relative;
        }

        .highlight-list li:before {
            content: "•";
            margin-right: 8px;
            font-size: 18px;
        }

        .strengths-list li:before {
            color: #38a169;
        }

        .improvements-list li:before {
            color: #dd6b20;
        }

        /* CTA Button */
        .cta-button {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 30px auto;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(102, 126, 234, 0.2);
        }

        /* Footer */
        .footer {
            background-color: #f7fafc;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer-text {
            color: #718096;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .footer-links {
            margin-top: 15px;
        }

        .footer-link {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .content {
                padding: 20px;
            }

            .header {
                padding: 25px 15px;
            }

            .header h1 {
                font-size: 24px;
            }

            .score-number {
                font-size: 48px;
            }

            .competencies-grid {
                grid-template-columns: 1fr;
            }

            .highlights {
                grid-template-columns: 1fr;
            }

            .cta-button {
                max-width: 100%;
            }
        }

        @media (max-width: 400px) {
            body {
                padding: 10px;
            }

            .header {
                padding: 20px 10px;
            }

            .content {
                padding: 15px;
            }

            .score-card {
                padding: 20px;
            }

            .score-number {
                font-size: 42px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">T</div>
            <h1>Your Teacher Appraisal is Ready! 🎉</h1>
            <p>AI-powered assessment based on Level-3 Competency Rubrics</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                <h2>Hello {{ $teacherName }},</h2>
                <p>Your AI-powered teacher appraisal has been completed. Here's a summary of your performance assessment based on the Level-3 teaching competency standards.</p>
            </div>

            <!-- Overall Score -->
            <div class="score-card">
                <div class="score-number">{{ $overallScore }}%</div>
                <div class="score-grade">{{ $grade }}</div>
                <p class="score-text">Overall Performance Score</p>
            </div>

            <!-- Competencies Breakdown -->
            <div class="competencies-section">
                <h3 class="section-title">Competency Performance Breakdown</h3>
                <div class="competencies-grid">
                    @foreach($competencies as $competency)
                    <div class="competency-item">
                        <div class="competency-name">{{ $competency['name'] }}</div>
                        <div class="competency-score">{{ $competency['score'] }}%</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Strengths & Improvements -->
            <div class="highlights">
                <!-- Strengths -->
                <div class="highlight-card strengths-card">
                    <div class="highlight-title strengths-title">
                        <span class="icon">✅</span>
                        Key Strengths
                    </div>
                    <ul class="highlight-list strengths-list">
                        @foreach($strengths as $strength)
                        <li>{{ $strength }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Improvement Areas -->
                <div class="highlight-card improvements-card">
                    <div class="highlight-title improvements-title">
                        <span class="icon">📈</span>
                        Areas for Improvement
                    </div>
                    <ul class="highlight-list improvements-list">
                        @foreach($improvementAreas as $area)
                        <li>{{ $area }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Feedback Summary -->
            <div style="margin: 30px 0; padding: 20px; background-color: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
                <h3 style="color: #2d3748; margin-bottom: 10px; font-size: 16px;">📝 Key Insights</h3>
                <p style="color: #4a5568; line-height: 1.6;">{{ $feedbackSummary }}</p>
            </div>

            <!-- CTA Button -->
            <a href="{{ $dashboardUrl }}" class="cta-button">
                View Complete Appraisal Report →
            </a>

            <!-- Additional Info -->
            <div style="text-align: center; margin-top: 20px; color: #718096; font-size: 14px;">
                <p>This appraisal was generated using advanced AI analysis of your profile against Level-3 teaching competency standards.</p>
                <p style="margin-top: 10px;">Your detailed report includes comprehensive feedback and actionable recommendations.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                © {{ date('Y') }} Teachergauge. All rights reserved.<br>
                This is an automated message. Please do not reply to this email.
            </p>
            <div class="footer-links">
                <a href="{{ $platformUrl }}" class="footer-link">Visit Platform</a>
                <a href="{{ $helpUrl }}" class="footer-link">Help Center</a>
                <a href="{{ $privacyUrl }}" class="footer-link">Privacy Policy</a>
            </div>
        </div>
    </div>
</body>
</html>
