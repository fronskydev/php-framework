<style>
    .home {
        color: var(--bs-active-color) !important;
        font-weight: 500;
        pointer-events: none;
    }
    .content {
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90vh;
    }
</style>

<div class="content">
    <div class="container text-center">
        <h1>Welcome to Fronsky® PHP Framework <?= $_ENV["APP_VERSION"] ?></h1>
        <p>Start building amazing web applications with ease!</p>
        <a href="<?= ROOT_URL . "/readme.md"?>" class="btn btn-primary default-rounded">Get Started</a>
        <br /><br />

        <small>
            To be able to see the readme.md file in the browser, you need to install a markdown viewer extension in your browser.<br />
            <a href="https://chromewebstore.google.com/detail/markdown-preview-plus/febilkbfcbhebfnokafefeacimjdckgl" target="_blank" class="text-primary">Click here to install an extension</a>
        </small>
    </div>
</div>