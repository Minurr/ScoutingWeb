<script src="https://unpkg.com/sober/dist/sober.min.js"></script>
<script>
  console.log(sober)
</script>

<br><br>

<header class="text-center p-5">
    <a href="/">
        <h1 class="text-4xl font-semibold"><?php echo $teamname ?> SCOUT</h1>
    </a>
    <form action="/view" class="inline-form" method="GET">
        <input type="text" id="team" name="team" placeholder="Search For TeamCode">
        <input type="submit" value="Submit">
    </form>
</header>

<section class="hero-section">
    <h2>F<?php echo $com_type ?>#<?php echo $team ?></h2>
    <h2 class="text-2xl">Welcome to  F<?php echo $com_type ?> 2025</h2>
    <p>Here is <?php echo $teamname ?>'s SCOUT site, you can find all kinds of data and analysis here.</p>
</section>
