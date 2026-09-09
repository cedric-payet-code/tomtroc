<div class="messenger">
    <aside class="chat-list">
        <h1 class="chat-list__title">Messagerie</h1>

        <?php foreach ($chats as $index => $selectedChat): ?>

            <?php
                $chat = $selectedChat['chat'];
                $user = $selectedChat['user'];
                $lastMessage = $selectedChat['lastMessage'];
                $lastMessageAt = $selectedChat['lastMessageAt'];
            ?>

            <a href="message/<?= htmlspecialchars($user->getId()) ?>"
               class="chat-item<?= $chat->getId() === $activeChatId ? ' chat-item--active' : '' ?>">

                <img src="assets/images/<?=htmlspecialchars($user->getAvatar() ?? 'profil.jpg') ?>" alt="Avatar de <?= htmlspecialchars($user->getUsername()) ?>" class="avatar chat-item__avatar">

                <div class="chat-item__body">
                    <div class="chat-item__top">
                        <span class="chat-item__name"><?= htmlspecialchars($user->getUsername()) ?></span>
                        <span class="chat-item__time"><?= htmlspecialchars($lastMessageAt) ?></span>
                    </div>
                    <?php if ($lastMessage): ?>
                        <p class="chat-item__preview">
                            <?= htmlspecialchars($lastMessage->getMessage()) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </aside>

    <section class="chat-panel">
        <?php if ($activeContact): ?>
            <div class="chat-panel__header">
                <img src="assets/images/<?=htmlspecialchars($activeContact->getAvatar() ?? 'profil.jpg') ?>" alt="Avatar de <?= htmlspecialchars($activeContact->getUsername()) ?>" class="avatar chat-panel__header-avatar">
                <span class="chat-panel__header-name"><?= htmlspecialchars($activeContact->getUsername()) ?></span>
            </div>

            <div class="chat-panel__thread">
                <?php foreach ($activeMessages as $activeMessage): ?>

                    <?php
                        $message = $activeMessage['message'];
                        $sentAt = $activeMessage['sentAt'];
                    ?>

                    <?php if ($message->getSenderId() == $_SESSION['user']->getId()): ?>
                        <div class="message message--sent">
                            <div class="message__bubble-wrapper">
                                <span class="message__time"><?= htmlspecialchars($sentAt) ?></span>
                                <div class="message__bubble"><?= htmlspecialchars($message->getMessage()) ?></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="message message--received">
                            <img src="assets/images/<?= htmlspecialchars($activeContact->getAvatar() ?? 'profil.jpg') ?>" alt="" class="avatar message__avatar">
                            <div class="message__bubble-wrapper">
                                <span class="message__time"><?= htmlspecialchars($sentAt) ?></span>
                                <div class="message__bubble"><?= htmlspecialchars($message->getMessage()) ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <form action="messagerie/<?= htmlspecialchars($activeChatId) ?>" method="post" class="chat-panel__form">
                <input type="text" name="content" class="chat-input" placeholder="Tapez votre message ici" required>
                <button type="submit" class="button button--primary chat-panel__submit">Envoyer</button>
            </form>
        <?php endif; ?>
    </section>
</div>