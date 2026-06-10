<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Management Dashboard - VVUpload</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #666;
            font-size: 0.9em;
        }

        .section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-title i {
            font-size: 1.8em;
            color: #667eea;
        }

        .section-title h2 {
            color: #333;
            font-size: 1.5em;
        }

        .section-title .badge {
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8em;
            margin-left: auto;
        }

        .portal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .portal-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .portal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
            border-color: #667eea;
        }

        .portal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .portal-card h3 {
            color: #333;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .portal-card p {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .portal-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 0.85em;
            color: #888;
        }

        .portal-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .portal-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-warning {
            background: #ffc107;
            color: #333;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .status-active {
            background: #28a745;
            box-shadow: 0 0 5px #28a745;
        }

        .status-inactive {
            background: #dc3545;
            box-shadow: 0 0 5px #dc3545;
        }

        .status-unknown {
            background: #ffc107;
            box-shadow: 0 0 5px #ffc107;
        }

        .nodejs-controls {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .nodejs-controls label {
            font-weight: bold;
            color: #333;
            margin-right: 10px;
        }

        .nodejs-controls code {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 0.9em;
        }

        .footer {
            text-align: center;
            color: white;
            margin-top: 40px;
            padding: 20px;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .portal-grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 1.8em;
            }
            
            .stats-bar {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 20px;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #667eea;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-th-large"></i> Portal Management Dashboard</h1>
            <p>Centralized control panel for all lead management portals and services</p>
        </div>

        <div class="stats-bar">
            <div class="stat-card">
                <h3><?php echo count(glob('*' . DIRECTORY_SEPARATOR . 'index.php')); ?></h3>
                <p>PHP Portals</p>
            </div>
            <div class="stat-card">
                <h3>4</h3>
                <p>Node.js Services</p>
            </div>
            <div class="stat-card">
                <h3><?php echo count(glob('*' . DIRECTORY_SEPARATOR . 'index.php')) + 4; ?></h3>
                <p>Total Systems</p>
            </div>
            <div class="stat-card">
                <h3><?php echo count(glob('*' . DIRECTORY_SEPARATOR . 'leads.csv')) + count(glob('*' . DIRECTORY_SEPARATOR . 'data.csv')); ?></h3>
                <p>Active Data Files</p>
            </div>
        </div>

        <!-- PHP Portals Section -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-server"></i>
                <h2>PHP Web Portals</h2>
                <span class="badge"><?php echo count(glob('*' . DIRECTORY_SEPARATOR . 'index.php')); ?> Active</span>
            </div>

            <div class="search-box">
                <input type="text" id="phpSearch" placeholder="🔍 Search PHP portals..." onkeyup="filterPortals('php', this.value)">
            </div>

            <div class="portal-grid" id="phpPortals">
                <!-- Neurons -->
                <div class="portal-card" data-name="neurons">
                    <h3><i class="fas fa-graduation-cap"></i> Neurons</h3>
                    <p>NoPaperForms integration for lead submission with course mapping and validation</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> leads.csv</span>
                        <span><i class="fas fa-link"></i> API Integration</span>
                    </div>
                    <div class="portal-actions">
                        <a href="neurons/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="neurons/leads.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View CSV</a>
                    </div>
                </div>

                <!-- Lexicon -->
                <div class="portal-card" data-name="lexicon">
                    <h3><i class="fas fa-book"></i> Lexicon</h3>
                    <p>CSV-based lead upload system with budget tracking and course management</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> leads.csv</span>
                        <span><i class="fas fa-link"></i> API Integration</span>
                    </div>
                    <div class="portal-actions">
                        <a href="lexicon/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="lexicon/leads.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View CSV</a>
                    </div>
                </div>

                <!-- CC -->
                <div class="portal-card" data-name="cc">
                    <h3><i class="fas fa-building"></i> CC Portal</h3>
                    <p>Database-driven enquiry management with individual and bulk API submission</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> MySQL Database</span>
                        <span><i class="fas fa-table"></i> DataTables</span>
                    </div>
                    <div class="portal-actions">
                        <a href="cc/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="cc/upload-leads.php" class="btn btn-warning"><i class="fas fa-upload"></i> Upload</a>
                    </div>
                </div>

                <!-- Riser -->
                <div class="portal-card" data-name="riser">
                    <h3><i class="fas fa-rocket"></i> StudyRiser</h3>
                    <p>Bulk CSV lead upload with detailed logging and validation for StudyRiser platform</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> leads.csv</span>
                        <span><i class="fas fa-link"></i> API Integration</span>
                    </div>
                    <div class="portal-actions">
                        <a href="riser/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="riser/leads.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View CSV</a>
                    </div>
                </div>

                <!-- SF -->
                <div class="portal-card" data-name="sf">
                    <h3><i class="fas fa-globe-asia"></i> SF (HK Leads)</h3>
                    <p>Hong Kong leads management system with database storage and API integration</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> MySQL Database</span>
                        <span><i class="fas fa-table"></i> DataTables</span>
                    </div>
                    <div class="portal-actions">
                        <a href="sf/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="sf/upload_hkleads.php" class="btn btn-warning"><i class="fas fa-upload"></i> Upload</a>
                    </div>
                </div>

                <!-- IES -->
                <div class="portal-card" data-name="ies">
                    <h3><i class="fas fa-university"></i> IES</h3>
                    <p>Educational enquiry management with bulk operations and individual submission</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> MySQL Database</span>
                        <span><i class="fas fa-table"></i> DataTables</span>
                    </div>
                    <div class="portal-actions">
                        <a href="ies/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="ies/upload.php" class="btn btn-warning"><i class="fas fa-upload"></i> Upload</a>
                    </div>
                </div>

                <!-- JKB -->
                <div class="portal-card" data-name="jkb">
                    <h3><i class="fas fa-school"></i> JKB</h3>
                    <p>Multi-target lead management with dual API submission (Main API + BSS)</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> MySQL Database</span>
                        <span><i class="fas fa-table"></i> DataTables</span>
                    </div>
                    <div class="portal-actions">
                        <a href="jkb/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="jkb/upload.php" class="btn btn-warning"><i class="fas fa-upload"></i> Upload</a>
                    </div>
                </div>

                <!-- LeadPush -->
                <div class="portal-card" data-name="leadpush">
                    <h3><i class="fas fa-paper-plane"></i> LeadPush</h3>
                    <p>Online MBA lead management system with comprehensive tracking</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> MySQL Database</span>
                        <span><i class="fas fa-table"></i> DataTables</span>
                    </div>
                    <div class="portal-actions">
                        <a href="leadpush/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="leadpush/upload.php" class="btn btn-warning"><i class="fas fa-upload"></i> Upload</a>
                    </div>
                </div>

                <!-- MPC -->
                <div class="portal-card" data-name="mpc">
                    <h3><i class="fas fa-vial"></i> MPC</h3>
                    <p>Test lead submission system for Meritto platform with JSON API</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-flask"></i> Testing</span>
                        <span><i class="fas fa-link"></i> JSON API</span>
                    </div>
                    <div class="portal-actions">
                        <a href="mpc/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="mpc/new.php" class="btn btn-warning"><i class="fas fa-sync"></i> Test</a>
                    </div>
                </div>

                <!-- Ads -->
                <div class="portal-card" data-name="ads">
                    <h3><i class="fas fa-chart-line"></i> Ads Keyword Research</h3>
                    <p>Google Ads keyword research data with search volume and competition metrics</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> MySQL Database</span>
                        <span><i class="fas fa-table"></i> DataTables</span>
                    </div>
                    <div class="portal-actions">
                        <a href="ads/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="ads/upload-sheet.php" class="btn btn-warning"><i class="fas fa-upload"></i> Upload</a>
                    </div>
                </div>

                <!-- NextUni -->
                <div class="portal-card" data-name="nextuni">
                    <h3><i class="fas fa-om"></i> NextUni (Hindi)</h3>
                    <p>NextUni API integration for Hindi medium leads with NEET score tracking</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> leads.csv</span>
                        <span><i class="fas fa-link"></i> REST API</span>
                    </div>
                    <div class="portal-actions">
                        <a href="nextuni/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="nextuni/leads.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View CSV</a>
                    </div>
                </div>

                <!-- NextUni English -->
                <div class="portal-card" data-name="nextunieng">
                    <h3><i class="fas fa-engineering"></i> NextUni Eng (Engineering)</h3>
                    <p>Engineering-focused NextUni portal with JEE score and rank tracking</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> leads.csv</span>
                        <span><i class="fas fa-link"></i> REST API</span>
                    </div>
                    <div class="portal-actions">
                        <a href="nextuniEng/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="nextuniEng/leads.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View CSV</a>
                    </div>
                </div>

                <!-- Ragistan -->
                <div class="portal-card" data-name="ragistan">
                    <h3><i class="fas fa-mountain"></i> Ragistan</h3>
                    <p>NoPaperForms integration with comprehensive lead data mapping</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> leads.csv</span>
                        <span><i class="fas fa-link"></i> API Integration</span>
                    </div>
                    <div class="portal-actions">
                        <a href="ragistan/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="ragistan/leads.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View CSV</a>
                    </div>
                </div>

                <!-- BSS -->
                <div class="portal-card" data-name="bss">
                    <h3><i class="fas fa-handshake"></i> BSS Foundation</h3>
                    <p>ExtraaEdge platform integration for foundation course leads</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> leads.csv</span>
                        <span><i class="fas fa-link"></i> Webhook API</span>
                    </div>
                    <div class="portal-actions">
                        <a href="bss/index.php" class="btn btn-primary"><i class="fas fa-external-link-alt"></i> Open Portal</a>
                        <a href="bss/leads.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View CSV</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Node.js Services Section -->
        <div class="section">
            <div class="section-title">
                <i class="fab fa-node-js"></i>
                <h2>Node.js Services</h2>
                <span class="badge">4 Services</span>
            </div>

            <div class="search-box">
                <input type="text" id="nodeSearch" placeholder="🔍 Search Node.js services..." onkeyup="filterPortals('node', this.value)">
            </div>

            <div class="portal-grid" id="nodePortals">
                <!-- ISMS -->
                <div class="portal-card" data-name="isms">
                    <h3><i class="fas fa-shield-alt"></i> ISMS Pune</h3>
                    <p>CRM integration for ISMS Pune with batch processing and retry mechanism</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> data.csv</span>
                        <span><i class="fas fa-server"></i> Port: 3000</span>
                    </div>
                    <div class="nodejs-controls">
                        <label><i class="fas fa-terminal"></i> Run:</label>
                        <code>cd isms && npm install && node index.js</code>
                    </div>
                    <div class="portal-actions" style="margin-top: 10px;">
                        <span class="btn btn-primary" onclick="checkService('isms')"><i class="fas fa-wifi"></i> Check Status</span>
                        <a href="isms/data.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View Data</a>
                    </div>
                </div>

                <!-- Gest/ReviewAdda -->
                <div class="portal-card" data-name="gest">
                    <h3><i class="fas fa-star"></i> Gest (ReviewAdda)</h3>
                    <p>Review management system with college and course mapping</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> data.csv</span>
                        <span><i class="fas fa-link"></i> CRM API</span>
                    </div>
                    <div class="nodejs-controls">
                        <label><i class="fas fa-terminal"></i> Run:</label>
                        <code>cd gest && npm install && node test.js</code>
                    </div>
                    <div class="portal-actions" style="margin-top: 10px;">
                        <span class="btn btn-primary" onclick="checkService('gest')"><i class="fas fa-wifi"></i> Check Status</span>
                        <a href="gest/data.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View Data</a>
                    </div>
                </div>

                <!-- Russia -->
                <div class="portal-card" data-name="russia">
                    <h3><i class="fas fa-globe-europe"></i> Russia Education</h3>
                    <p>International student lead management for Russian universities</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> data.csv</span>
                        <span><i class="fas fa-link"></i> REST API</span>
                    </div>
                    <div class="nodejs-controls">
                        <label><i class="fas fa-terminal"></i> Run:</label>
                        <code>cd russia && npm install && node index.js</code>
                    </div>
                    <div class="portal-actions" style="margin-top: 10px;">
                        <span class="btn btn-primary" onclick="checkService('russia')"><i class="fas fa-wifi"></i> Check Status</span>
                        <a href="russia/data.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View Data</a>
                    </div>
                </div>

                <!-- ReviewAdd -->
                <div class="portal-card" data-name="reviewadd">
                    <h3><i class="fas fa-comment-alt"></i> ReviewAdd</h3>
                    <p>Advanced review collection system with enhanced data processing</p>
                    <div class="portal-meta">
                        <span><i class="fas fa-database"></i> data.csv</span>
                        <span><i class="fas fa-cog"></i> Auto Processing</span>
                    </div>
                    <div class="nodejs-controls">
                        <label><i class="fas fa-terminal"></i> Run:</label>
                        <code>cd reviewadd && npm install && node index.js</code>
                    </div>
                    <div class="portal-actions" style="margin-top: 10px;">
                        <span class="btn btn-primary" onclick="checkService('reviewadd')"><i class="fas fa-wifi"></i> Check Status</span>
                        <a href="reviewadd/data.csv" class="btn btn-success"><i class="fas fa-file-csv"></i> View Data</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p><i class="fas fa-code"></i> Portal Management Dashboard v1.0 | VVUpload System</p>
            <p style="margin-top: 5px; font-size: 0.9em;">Total Systems: <?php echo count(glob('*' . DIRECTORY_SEPARATOR . 'index.php')) + 4; ?> | Last Updated: <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
    </div>

    <script>
        function filterPortals(type, searchTerm) {
            const container = type === 'php' ? document.getElementById('phpPortals') : document.getElementById('nodePortals');
            const cards = container.getElementsByClassName('portal-card');
            
            searchTerm = searchTerm.toLowerCase();
            
            for (let card of cards) {
                const name = card.getAttribute('data-name').toLowerCase();
                const text = card.textContent.toLowerCase();
                
                if (name.includes(searchTerm) || text.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            }
        }

        function checkService(serviceName) {
            alert(`Checking status of ${serviceName} service...\n\nTo start the service, open terminal and run:\ncd ${serviceName} && npm install && node index.js (or test.js for gest)`);
        }

        // Initialize DataTables for any tabular data if needed
        $(document).ready(function() {
            console.log('Dashboard loaded successfully');
        });
    </script>
</body>
</html>