<style>
  .v38-updates-grid {
    display: grid;
    grid-gap: var(--spacing-6);
    grid-template-columns: 1fr;
    grid-template-areas: "figure"
      "box1"
      "box2";
  }

  @media screen and (min-width: 60rem) {
    .v38-updates-grid {
      grid-template-columns: 1fr 1fr;
      grid-template-areas: "figure figure"
        "box1 box2";
    }
  }

  .v38-updates-grid .release-code-box .code-toolbar {
    height: 100%;
  }
</style>

<section id="updates" class="mb-42">

  <?php snippet('hgroup', [
    'title'    => 'New update checks',
    'subtitle' => 'Keep your installation healthy',
    'mb'       => 12
  ]) ?>

  <div class="v38-updates-grid">

    <figure class="release-box bg-light" style="--aspect-ratio: 2473/1594; grid-area: figure">
      <img src="<?= $page->image('updates.png')?->url() ?>" loading="lazy" alt="The system view now shows available updates for Kirby and installed plugins">
    </figure>

    <div class="release-text-box" style="grid-area: box1">
      <h3>Always up to date</h3>
      <div class="prose">
        <?= $page->updatesInfo()->kt() ?>
      </div>
    </div>
    <div class="release-code-box" style="grid-area: box2">
      <?= $page->updatesConfig()->kt() ?>
    </div>
  </div>

</section>
