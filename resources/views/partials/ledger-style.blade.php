<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    .ledger-page {
        --lg-parchment: #F7F2E7;
        --lg-card: #FFFCF5;
        --lg-ink: #17301F;
        --lg-ink-soft: #5B6B5E;
        --lg-green: #0F5132;
        --lg-green-deep: #0A3A24;
        --lg-gold: #A9761E;
        --lg-gold-soft: #F0DEB4;
        --lg-border: #E2DAC5;
        background: var(--lg-parchment);
        color: var(--lg-ink);
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 32px 24px 60px;
        border-radius: 16px;
    }
    .ledger-page .lg-eyebrow {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--lg-gold);
        font-weight: 600;
        margin-bottom: 10px;
    }
    .ledger-page .lg-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 28px;
        border-bottom: 1px solid var(--lg-border);
        padding-bottom: 24px;
    }
    .ledger-page h1.lg-title {
        font-family: 'Amiri', serif;
        font-weight: 700;
        font-size: 32px;
        margin: 0 0 6px 0;
        color: var(--lg-green-deep);
    }
    .ledger-page .lg-subtitle { font-size: 14px; color: var(--lg-ink-soft); margin: 0; max-width: 420px; line-height: 1.5; }
    .ledger-page .lg-actions { display: flex; gap: 10px; flex-shrink: 0; flex-wrap: wrap; }
    .ledger-page .lg-btn {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 13px;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        border: 1px solid transparent;
    }
    .ledger-page .lg-btn-ghost { background: transparent; border-color: var(--lg-border); color: var(--lg-ink); }
    .ledger-page .lg-btn-ghost:hover { background: #fff; color: var(--lg-ink); }
    .ledger-page .lg-btn-solid { background: var(--lg-green); color: #fff; border-color: var(--lg-green); }
    .ledger-page .lg-btn-solid:hover { background: var(--lg-green-deep); color: #fff; }
    .ledger-page .lg-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .ledger-page .lg-btn-block { width: 100%; justify-content: center; }

    .ledger-page .lg-tabs { display: flex; gap: 4px; margin-bottom: 24px; flex-wrap: wrap; }
    .ledger-page .lg-tab {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 7px 14px;
        border-radius: 999px;
        border: 1px solid var(--lg-border);
        color: var(--lg-ink-soft);
        background: var(--lg-card);
        text-decoration: none;
    }
    .ledger-page .lg-tab.active { background: var(--lg-green); border-color: var(--lg-green); color: #fff; }

    .ledger-page .lg-ledger { display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px; }

    .ledger-page .lg-card {
        position: relative;
        background: var(--lg-card);
        border: 1px solid var(--lg-border);
        border-radius: 10px;
        padding: 22px 24px;
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }
    .ledger-page .lg-card::before {
        content: "";
        position: absolute;
        left: 0; top: 14px; bottom: 14px;
        width: 3px;
        background: repeating-linear-gradient(180deg, var(--lg-gold) 0 6px, transparent 6px 12px);
        border-radius: 2px;
    }
    .ledger-page .lg-card-main { padding-left: 14px; flex: 1; min-width: 220px; }
    .ledger-page .lg-surah-name { font-family: 'Amiri', serif; font-weight: 700; font-size: 22px; color: var(--lg-green-deep); margin: 0 0 4px 0; }
    .ledger-page .lg-meta-row {
        font-family: 'JetBrains Mono', monospace;
        font-size: 12px;
        color: var(--lg-ink-soft);
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .ledger-page .lg-meta-row b { color: var(--lg-ink); font-weight: 600; }
    .ledger-page .lg-catatan { font-size: 13px; color: var(--lg-ink-soft); font-style: italic; margin: 0 0 10px 0; max-width: 440px; }
    .ledger-page .lg-detail-link { font-size: 12px; font-weight: 600; color: var(--lg-green); text-decoration: none; }

    .ledger-page .lg-stamp-wrap { flex-shrink: 0; display: flex; align-items: center; gap: 14px; }
    .ledger-page .lg-stamp {
        width: 72px; height: 72px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-family: 'JetBrains Mono', monospace;
        text-align: center;
        flex-shrink: 0;
    }
    .ledger-page .lg-stamp.lg-dinilai { border: 2.5px solid var(--lg-green); color: var(--lg-green-deep); transform: rotate(6deg); }
    .ledger-page .lg-stamp.lg-dinilai .lg-score { font-size: 20px; font-weight: 700; line-height: 1; }
    .ledger-page .lg-stamp .lg-label { font-size: 8px; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 2px; }
    .ledger-page .lg-stamp.lg-menunggu { border: 2px dashed var(--lg-gold); color: var(--lg-gold); transform: rotate(-6deg); }
    .ledger-page .lg-stamp.lg-menunggu .lg-label { font-size: 9px; line-height: 1.3; }
    .ledger-page .lg-stamp.lg-large { width: 96px; height: 96px; }
    .ledger-page .lg-stamp.lg-large .lg-score { font-size: 26px; }

    .ledger-page .lg-empty {
        text-align: center;
        padding: 50px 20px;
        color: var(--lg-ink-soft);
        font-size: 14px;
        background: var(--lg-card);
        border: 1px dashed var(--lg-border);
        border-radius: 10px;
    }

    .ledger-page .lg-section {
        background: var(--lg-card);
        border: 1px solid var(--lg-border);
        border-radius: 10px;
        padding: 28px;
        margin-bottom: 24px;
    }
    .ledger-page .lg-section-title { font-family: 'Amiri', serif; font-weight: 700; font-size: 20px; color: var(--lg-green-deep); margin: 0 0 4px 0; }
    .ledger-page .lg-section-sub { font-size: 13px; color: var(--lg-ink-soft); margin: 0 0 6px 0; }

    .ledger-page .lg-form-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 14px; margin-bottom: 14px; }
    .ledger-page label.lg-field-label { display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--lg-ink-soft); margin-bottom: 6px; font-family: 'JetBrains Mono', monospace; }
    .ledger-page select.lg-input,
    .ledger-page input.lg-input,
    .ledger-page textarea.lg-input {
        width: 100%;
        padding: 10px 12px;
        border-radius: 7px;
        border: 1px solid var(--lg-border);
        background: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        color: var(--lg-ink);
    }
    .ledger-page .lg-form-group { margin-bottom: 16px; }

    .ledger-page .lg-record-box {
        border: 1px dashed var(--lg-border);
        border-radius: 8px;
        padding: 18px;
        text-align: center;
        margin-bottom: 18px;
    }
    .ledger-page .lg-mic-btn {
        border-radius: 30px;
        background: var(--lg-green);
        color: #fff;
        border: none;
        padding: 10px 22px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
    }
    .ledger-page .lg-mic-btn.lg-recording { background: #b03a2e; }
    .ledger-page .lg-record-hint { font-size: 12px; color: var(--lg-ink-soft); margin: 10px 0 0 0; }
    .ledger-page audio { width: 100%; margin-top: 12px; }

    .ledger-page .lg-nilai-table { width: 100%; font-size: 13px; border-collapse: collapse; margin-bottom: 14px; }
    .ledger-page .lg-nilai-table td { padding: 8px 0; border-bottom: 1px solid var(--lg-border); }
    .ledger-page .lg-nilai-table td:last-child { text-align: right; font-family: 'JetBrains Mono', monospace; font-weight: 600; }

    .ledger-page .lg-total-preview {
        background: var(--lg-gold-soft);
        color: #6B4A10;
        border: 1px solid #E4C583;
        border-radius: 8px;
        padding: 12px 16px;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .ledger-page .lg-alert { border-radius: 8px; padding: 12px 16px; font-size: 13px; margin-bottom: 20px; }
    .ledger-page .lg-alert-success { background: #E6F1E4; color: var(--lg-green-deep); border: 1px solid #BFE0BA; }
    .ledger-page .lg-alert-danger { background: #FBE9E7; color: #7B241C; border: 1px solid #F0C4BE; }
    .ledger-page .lg-alert-info { background: var(--lg-gold-soft); color: #6B4A10; border: 1px solid #E4C583; }
    .ledger-page .lg-alert ul { margin: 0; padding-left: 18px; }

    .ledger-page .lg-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: var(--lg-ink-soft);
        text-decoration: none;
        margin-bottom: 20px;
    }
    .ledger-page .lg-back:hover { color: var(--lg-ink); }

    @media (max-width: 640px) {
        .ledger-page .lg-form-grid { grid-template-columns: 1fr; }
        .ledger-page .lg-card { flex-direction: column; }
        .ledger-page .lg-stamp-wrap { align-self: flex-start; }
    }
</style>