<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartCafe | Hóa đơn</title>
    <style>
        :root { color-scheme: light; --ink:#28221d; --muted:#81766d; --coffee:#70452f; --cream:#f5f0e8; --line:#eee7df; }
        * { box-sizing:border-box; }
        body { margin:0; background:var(--cream); color:var(--ink); font:15px/1.55 Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }
        .topbar { height:68px; display:flex; align-items:center; justify-content:space-between; padding:0 max(24px, calc((100% - 1120px)/2)); background:#fff; border-bottom:1px solid var(--line); }
        .brand { display:flex; align-items:center; gap:11px; color:var(--coffee); font-weight:800; font-size:19px; letter-spacing:-.4px; }
        .cup { display:grid; place-items:center; width:36px; height:36px; border-radius:12px; background:#f3e8da; font-size:20px; }
        .top-note { color:var(--muted); font-size:13px; }
        main { width:min(1120px, calc(100% - 40px)); margin:42px auto 72px; }
        .intro { display:flex; align-items:flex-end; justify-content:space-between; gap:20px; margin-bottom:25px; }
        h1 { margin:0; font-size:clamp(27px,4vw,36px); line-height:1.15; letter-spacing:-1.2px; }
        .subtle { margin:8px 0 0; color:var(--muted); }
        .demo-tag { flex:none; padding:7px 11px; border:1px solid #e6d9c9; border-radius:99px; color:#805a3f; background:#fbf6ef; font-size:12px; font-weight:700; }
        .layout { display:grid; grid-template-columns:minmax(0,1.45fr) minmax(280px,.8fr); gap:22px; align-items:start; }
        .card { background:#fff; border:1px solid #eee8e1; border-radius:18px; box-shadow:0 10px 30px #45301b0a; }
        .receipt { padding:26px 28px 24px; }
        .section-heading { display:flex; justify-content:space-between; align-items:center; padding-bottom:18px; border-bottom:1px solid var(--line); }
        .section-heading h2, .details h2 { margin:0; font-size:17px; letter-spacing:-.25px; }
        .eyebrow { color:var(--muted); font-size:11px; font-weight:800; letter-spacing:1.2px; text-transform:uppercase; }
        .product { display:flex; justify-content:space-between; gap:16px; padding:22px 0; border-bottom:1px dashed #e9e1d8; }
        .product-name { font-weight:750; font-size:16px; }
        .product-meta { margin-top:4px; color:var(--muted); font-size:13px; }
        .product-price { white-space:nowrap; font-weight:700; }
        table { width:100%; border-collapse:collapse; margin:9px 0 0; }
        th, td { padding:11px 0; border-bottom:1px solid #f1ece7; text-align:left; }
        th { color:var(--muted); font-size:12px; font-weight:700; }
        td:last-child, th:last-child { text-align:right; white-space:nowrap; }
        .total td { padding-top:17px; border:0; color:var(--coffee); font-size:17px; font-weight:800; }
        .status { display:flex; align-items:center; gap:10px; margin:10px 0 0; padding:13px 15px; border-radius:12px; background:#edf6ed; color:#30653b; font-size:13px; font-weight:750; }
        .dot { width:8px; height:8px; border-radius:50%; background:#48a65c; box-shadow:0 0 0 4px #dceedd; }
        .side { display:grid; gap:16px; }
        .summary { padding:23px; background:#70452f; color:#fff; overflow:hidden; position:relative; }
        .summary:after { content:""; position:absolute; width:150px; height:150px; right:-54px; top:-58px; border:1px solid #ffffff20; border-radius:50%; box-shadow:0 0 0 18px #ffffff0a, 0 0 0 38px #ffffff08; }
        .summary .eyebrow { color:#e4c9af; }
        .summary-label { margin-top:19px; color:#f0dfcf; font-size:13px; }
        .amount { margin:3px 0 0; font-size:clamp(27px,4vw,34px); letter-spacing:-1px; font-weight:800; }
        .summary-foot { margin-top:18px; padding-top:14px; border-top:1px solid #ffffff30; color:#f0dfcf; font-size:12px; }
        .details { padding:21px 22px; }
        .details p { margin:11px 0 0; color:var(--muted); font-size:13px; }
        .details code { color:var(--coffee); }
        details { margin-top:16px; border-top:1px solid var(--line); padding-top:13px; }
        summary { cursor:pointer; color:var(--coffee); font-size:13px; font-weight:750; }
        pre { margin:12px 0 0; padding:13px; overflow:auto; border-radius:10px; background:#f7f4f0; color:#51453a; font-size:12px; }
        footer { margin-top:22px; color:#978b80; text-align:center; font-size:12px; }
        @media (max-width:740px) { .topbar { padding:0 20px; } main { margin-top:28px; } .layout { grid-template-columns:1fr; } .intro { align-items:flex-start; flex-direction:column; } .receipt { padding:22px 20px; } }
    </style>
</head>
<body>
<header class="topbar"><div class="brand"><span class="cup">☕</span> SmartCafe</div><span class="top-note">Không gian cà phê · Hóa đơn mẫu</span></header>
<main>
    <section class="intro"><div><h1>Chi tiết hóa đơn</h1><p class="subtle">Tóm tắt đơn hàng và cách PHP tính toán từng khoản.</p></div><span class="demo-tag">BẢN DEMO · DỮ LIỆU MẪU</span></section>
    <div class="layout">
        <section class="card receipt">
            <div class="section-heading"><div><div class="eyebrow">Order summary</div><h2>Thông tin đơn hàng</h2></div><span aria-hidden="true">🧾</span></div>
            <div class="product"><div><div class="product-name"><?= htmlspecialchars($productName, ENT_QUOTES, 'UTF-8') ?></div><div class="product-meta"><?= number_format($unitPrice, 0, ',', '.') ?> <?= CURRENCY ?> / ly · Số lượng <?= $quantity ?></div></div><div class="product-price"><?= number_format($subtotal, 0, ',', '.') ?> <?= CURRENCY ?></div></div>
            <table aria-label="Chi tiết thanh toán">
                <thead><tr><th>Khoản mục</th><th>Giá trị</th></tr></thead>
                <tbody>
                    <tr><td>Tạm tính</td><td><?= number_format($subtotal, 0, ',', '.') ?> <?= CURRENCY ?></td></tr>
                    <tr><td>Ưu đãi thành viên</td><td>− <?= number_format($discount, 0, ',', '.') ?> <?= CURRENCY ?></td></tr>
                    <tr><td>Phí bao bì</td><td><?= number_format($packagingFee, 0, ',', '.') ?> <?= CURRENCY ?></td></tr>
                    <tr><td>Phí dịch vụ</td><td><?= number_format($serviceFee, 0, ',', '.') ?> <?= CURRENCY ?></td></tr>
                    <tr class="total"><td>Tổng thanh toán</td><td><?= number_format($total, 0, ',', '.') ?> <?= CURRENCY ?></td></tr>
                </tbody>
            </table>
            <p class="status"><span class="dot"></span> Trạng thái: <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></p>
        </section>
        <aside class="side">
            <section class="card summary"><div class="eyebrow">Total due</div><div class="summary-label">Khách cần thanh toán</div><p class="amount"><?= number_format($total, 0, ',', '.') ?> <span style="font-size:16px;letter-spacing:0"><?= CURRENCY ?></span></p><div class="summary-foot">Khách hàng: <?= htmlspecialchars($customerStatus, ENT_QUOTES, 'UTF-8') ?> · <?= $productAvailable ? 'Còn phục vụ' : 'Tạm hết món' ?></div></section>
            <section class="card details"><h2>Thông tin xử lý</h2><p>Số lượng gốc: <strong><?= htmlspecialchars($rawQuantity, ENT_QUOTES, 'UTF-8') ?></strong> → sau chuẩn hóa: <strong><?= $quantity ?></strong></p><p>Kiểu dữ liệu: <code><?= gettype($rawQuantity) ?></code> → <code><?= gettype($quantity) ?></code></p><p>Giảm giá áp dụng cho MEMBER khi tạm tính từ <?= number_format(MEMBER_MIN, 0, ',', '.') ?> <?= CURRENCY ?>.</p><details><summary>Xem dữ liệu var_dump</summary><pre><?php var_dump($rawQuantity, $cleanQuantityString, $quantity, $customerStatus, $productAvailable, $orderNote); ?></pre></details></section>
        </aside>
    </div>
    <footer>SmartCafe · PHP Fundamentals · Nội dung minh họa từ dữ liệu mẫu, chưa nhận dữ liệu từ form.</footer>
</main>
</body>
</html>
