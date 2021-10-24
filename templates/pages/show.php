<div class="show">

    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note) : ?>
        <ul>
            <li>
                Id: <?php echo (int)$note['id']; ?>
            </li>
            <li>
                Tytuł: <?php echo htmlentities($note['title']); ?>
            </li>
            <li>
                Opis: <?php echo htmlentities($note['description']); ?>
            </li>
            <li>
                Stworzono: <?php echo htmlentities($note['created']); ?>
            </li>
        </ul>
    <?php else : ?>
        <p> Notatka nie została znaleziona </p>
    <?php endif; ?>
    <a href="/"> <button> Powrót do listy notatek </button></a>
</div>