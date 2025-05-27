<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Blood Search</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #991b1b;
      color: white;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
    }

    header h1 {
      margin: 0;
      font-size: 1.5rem;
      font-weight: bold;
    }

    .top-buttons a {
      background: white;
      color: black;
      padding: 8px 14px;
      margin-left: 10px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 0.9rem;
      border: none;
    }

    main {
      text-align: center;
      padding: 100px 20px 60px;
    }

    main h2 {
      font-size: 2.5rem;
      margin-bottom: 10px;
      font-weight: bold;
    }

    main p {
      max-width: 600px;
      margin: 0 auto 40px;
      line-height: 1.6;
      font-size: 1.1rem;
    }

    .search-bar {
      display: flex;
      justify-content: center;
      gap: 10px;
    }

    .search-bar input,
    .search-bar select {
      padding: 12px 18px;
      font-size: 1rem;
      border-radius: 8px;
      border: none;
      width: 300px;
    }

    .search-bar button {
      background-color: #0f172a;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
    }

    .search-bar button:hover {
      background-color: #1e293b;
    }
  </style>
</head>
<body>

<header>
  <h1>Blood Search</h1>
  <div class="top-buttons">
    <a href="/sang/public/user/profil">Mon profil</a>
    <a href="/sang/public/demande/mesDemandes">Mes demandes</a>
    <a href="/sang/public/user/logout"> Déconnexion</a>
    <h2>Bienvenue <?= htmlspecialchars($_SESSION['user']['prenom']) ?> (Demandeur)</h2>
  </div>
</header>

<main>
  <h2>Trouver Du Sang À Partir De Votre Emplacement.</h2>
  <p>Bienvenue sur la plateforme qui vous aide à trouver des poches de sang le plus vite possible et à proximité de votre emplacement.</p>
  
  <form class="search-bar" action="/sang/public/recherche/resultats" method="post">
    <select name="ref_sang" required>
      <option value="">Choisissez un groupe sanguin</option>
      <option value="A+">A+</option>
      <option value="A-">A-</option>
      <option value="B+">B+</option>
      <option value="B-">B-</option>
      <option value="O+">O+</option>
      <option value="O-">O-</option>
      <option value="AB+">AB+</option>
      <option value="AB-">AB-</option>
    </select>
    <button type="submit">Rechercher</button>
  </form>
</main>

</body>
</html>