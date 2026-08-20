<?php // Shared create/edit form. Expects $mode, $note (edit only), $old, $errors, $heading. ?>
<?php require __DIR__ . "/partials/head.php"; ?>
<?php require __DIR__ . "/partials/nav.php"; ?>
<?php require __DIR__ . "/partials/banner.php"; ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 text-white">
    <form
      method="POST"
      action="<?= $mode === 'edit' ? '/notes/' . e($note['id']) : '/notes/create' ?>"
      class="max-w-2xl"
    >
      <label for="body" class="block text-sm font-medium text-gray-300">Note</label>

      <textarea
        id="body"
        name="body"
        rows="6"
        class="mt-2 block w-full rounded-md border-0 bg-gray-800 px-3 py-2 text-white ring-1 ring-inset ring-white/10 placeholder:text-gray-500 focus:ring-2 focus:ring-indigo-500"
        placeholder="Write something..."
      ><?= old('body', $old) ?></textarea>

      <?php if (!empty($errors['body'])): ?>
        <ul class="mt-2 space-y-1 text-sm text-red-400">
          <?php foreach ($errors['body'] as $error): ?>
            <li><?= e($error) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <div class="mt-4 flex items-center gap-4">
        <button
          type="submit"
          class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-500"
        >
          <?= $mode === 'edit' ? 'Update Note' : 'Save Note' ?>
        </button>
        <a href="/notes" class="text-sm text-gray-400 hover:text-white">Cancel</a>
      </div>
    </form>

    <?php if ($mode === 'edit'): ?>
      <form
        method="POST"
        action="/notes/<?= e($note['id']) ?>/delete"
        class="mt-8 max-w-2xl border-t border-white/10 pt-6"
        onsubmit="return confirm('Delete this note? This cannot be undone.');"
      >
        <button type="submit" class="text-sm text-red-400 hover:text-red-300">
          Delete this note
        </button>
      </form>
    <?php endif; ?>
  </div>
</main>
</div>

<?php require __DIR__ . "/partials/mobile-menu.php"; ?>
<?php require __DIR__ . "/partials/footer.php"; ?>
