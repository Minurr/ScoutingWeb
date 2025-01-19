<script src="https://unpkg.com/sober/dist/sober.min.js"></script>
<script>
  console.log(sober)
</script>

<br>

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
    <h2 class="text-2xl">欢迎来到 F<?php echo $com_type ?> 2025</h2>
    <p>这里是<?php echo $teamname ?>的SCOUT网站，你可以在这里找到各种类型的数据和技巧、分类。</p>
</section>
