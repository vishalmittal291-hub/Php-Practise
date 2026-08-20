<?php // Expects $notes (rows from Database::get()) and $heading from NotesController::index() ?>
<?php require __DIR__ . "/partials/head.php"; ?>
<?php require __DIR__ . "/partials/nav.php"; ?>
<?php require __DIR__ . "/partials/banner.php"; ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 text-white">
    <div class="flex items-center justify-between">
      <p class="text-gray-400">All your notes, newest first.</p>
      <a
        href="/notes/create"
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-500"
      >
        + New Note
      </a>
    </div>

    <?php if (empty($notes)): ?>
      <p class="mt-6 text-gray-500">You don't have any notes yet.</p>
    <?php else: ?>
      <ul class="mt-6 divide-y divide-white/10 overflow-hidden rounded-md bg-gray-800/50 outline-1 -outline-offset-1 outline-white/10">
        <?php foreach ($notes as $note): ?>
          <li>
            <a href="/notes/<?= e($note['id']) ?>" class="block px-4 py-4 hover:bg-white/5 sm:px-6">
              <p class="line-clamp-2 text-sm text-gray-200"><?= e($note['body']) ?></p>
              <p class="mt-1 text-xs text-gray-500"><?= e($note['created_at']) ?></p>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</main>
</div>

<?php require __DIR__ . "/partials/mobile-menu.php"; ?>
<?php require __DIR__ . "/partials/footer.php"; ?>
