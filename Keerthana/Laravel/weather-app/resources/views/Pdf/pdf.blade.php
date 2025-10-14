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
        }
        h1 {
            text-align: center;
            text-decoration: underline;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            font-size: 18px;
        }
        .content {
            margin-left: 20px;
        }
    </style>
</head>
<body>

    <h1>{{ $data['name'] }}'s Resume</h1>
    
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Date:</strong> {{ $data['date'] }}</p>

    <!-- Skills Section -->
    <div class="section-title">Skills:</div>
    <div class="content">
        <ul>
            @foreach($data['skills'] as $skill)
                <li>{{ $skill }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Education Section -->
    <div class="section-title">Education:</div>
    <div class="content">
        <ul>
            @foreach($data['education'] as $edu)
                <li>
                    @if(is_array($edu))
                        {{ $edu['degree'] ?? '' }} - {{ $edu['institution'] ?? '' }} ({{ $edu['year'] ?? '' }})
                    @else
                        {{ $edu }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Certificates Section -->
    <div class="section-title">Certificates:</div>
    <div class="content">
        <ul>
            @foreach($data['certificates'] as $cert)
                <li>{{ $cert }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Projects Section -->
    <div class="section-title">Projects:</div>
    <div class="content">
        <ul>
            @foreach($data['projects'] as $project)
                <li>
                    @if(is_array($project))
                        {{ $project['title'] ?? '' }} - {{ $project['description'] ?? '' }}
                    @else
                        {{ $project }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Hobbies Section -->
    <div class="section-title">Hobbies:</div>
    <div class="content">
        <ul>
            @foreach($data['hobbies'] as $hobby)
                <li>{{ $hobby }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Experiences Section -->
    <div class="section-title">Work Experience:</div>
    <div class="content">
        <ul>
            @foreach($data['experiences'] as $experience)
                <li>
                    @if(is_array($experience))
                        {{ $experience['role'] ?? '' }} at {{ $experience['company'] ?? '' }} {{ $experience['years'] ?? '' }}
                    @else
                        {{ $experience }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

</body>
</html>
