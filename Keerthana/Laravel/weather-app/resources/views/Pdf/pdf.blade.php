<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['name'] }}'s Resume</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: black;
            background-color: white;
        }
        h1 {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            font-size: 16px;
            color: gray;
        }
        .section-title {
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
            /* border-bottom: 2px solid black; */
            padding-bottom: 5px;
        }
        .content {
            margin-left: 20px;
            font-size: 16px;
        }
        .list-item {
            margin-bottom: 10px;
        }
        ul {
            padding-left: 0;
            list-style: none;
        }
        .line {
            border-bottom: 1px solid black;
            margin: 20px 0;
        }
        .section-content {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <!-- Normal Details Section -->
    <h1>{{ $data['name'] }}</h1>
    <div class="subtitle">{{ $data['email'] }} | {{ $data['phone'] }}</div>
    
    <div class="line"></div>

    <!-- Summary Section -->
    <div class="section-title">SUMMARY</div>
    <div class="content">
        <p>{{ $data['summary'] }}</p>
    </div>

    <div class="line"></div>

    <!-- Work Experience Section -->
    <div class="section-title">WORK EXPERIENCE</div>
    <div class="content">
        <ul>
            @foreach($data['experiences'] as $experience)
                <li class="list-item">
                    <strong>{{ $experience['company'] ?? '' }} | {{ $experience['role'] ?? '' }} </strong> 
                    <span>({{ $experience['years'] ?? '' }})</span>
                    <ul style="list-style-type:disc;">
                        @foreach($experience['responsibilities'] as $responsibility)
                            <li>{{ $responsibility }}</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="line"></div>

    <!-- Education Section -->
    <div class="section-title">EDUCATION</div>
    <div class="content">
        <ul style="list-style-type:disc;">
            @foreach($data['education'] as $edu)
                <li class="list-item">
                    <strong>{{ $edu['degree'] ?? '' }}</strong> at {{ $edu['institution'] ?? '' }} ({{ $edu['year'] ?? '' }}) - CGPA: {{ $edu['cgpa'] ?? '' }}
                </li>
            @endforeach
        </ul>
    </div>

    <div class="line"></div>

    <!-- Skills Section -->
    <div class="section-title">SKILLS</div>
    <div class="content">
        <ul>
            <li><strong>Technical Skills:</strong> 
                @foreach($data['skills']['technical'] as $skill)
                    {{ $skill }}@if(!$loop->last), @endif
                @endforeach
            </li>
            <li><strong>Soft Skills:</strong> 
                @foreach($data['skills']['soft'] as $skill)
                    {{ $skill }}@if(!$loop->last), @endif
                @endforeach
            </li>
        </ul>
    </div>

    <div class="line"></div>

    <!-- Certificates Section -->
    <div class="section-title">CERTIFICATES</div>
    <div class="content">
        <ul>
            @foreach($data['certificates'] as $cert)
                <li>{{ $cert }}</li>
            @endforeach
        </ul>
    </div>

    <div class="line"></div>

    <!-- Projects Section -->
    <div class="section-title">PROJECTS</div>
    <div class="content">
        <ul>
            @foreach($data['projects'] as $project)
                <li>
                    <strong>{{ $project['title'] ?? '' }}</strong>
                    <ul style="list-style-type:disc;">
                        @foreach($project['description'] as $desc)
                            <li>{{ $desc }}</li>
                        @endforeach
                </li>
            @endforeach
        </ul>
    </div>

    <div class="line"></div>

    <!-- Hobbies Section -->
    <div class="section-title">HOBBIES</div>
    <div class="content">
        <ul>
            @foreach($data['hobbies'] as $hobby)
                <li>{{ $hobby }}</li>
            @endforeach
        </ul>
    </div>

    <div class="line"></div>

    <!-- Languages Section -->
    <div class="section-title">LANGUAGES</div>
    <div class="content">
        <ul>
            @foreach($data['languages'] as $language)
                <li>{{ $language }}</li>
            @endforeach
        </ul>
    </div>

</body>
</html>
