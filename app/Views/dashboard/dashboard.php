<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<style>
    .container {
        text-align: center;
        background-color: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    h1 {
        color: #333; /* Darker heading color */
        margin-bottom: 20px;
    }

    p {
        color: #666; /* Slightly lighter text color */
        margin-bottom: 30px;
    }

    .countdown {
        font-size: 2em;
        font-weight: bold;
        color: #007bff; /* Blue countdown color */
    }

    /* Optional: Add some styling for a progress bar */
    .progress-bar {
        width: 80%;
        margin: 20px auto;
        height: 20px;
        background-color: #e0e0e0;
        border-radius: 5px;
        overflow: hidden; /* Hide overflowing progress */
    }

    .progress {
        height: 100%;
        width: 50%; /* Example progress - adjust as needed */
        background-color: #007bff;
        border-radius: 5px;
    }
</style>

<div class="container">
    <h1>Module Coming Soon</h1>
    <p>We're working on something awesome!</p>
    <p>Stay tuned for updates.</p>
</div>

<script>
    
</script>

<?= $this->endSection() ?>