<div class="sidebar">
    <div class="sidebar-menu">
      <a href="/dashboard" class="sidebar-item">
        <i class="fas fa-tachometer-alt"></i> Tableau de bord
      </a>
      <a href="/clients" class="sidebar-item">
        <i class="fas fa-users"></i> Clients
      </a>
      <a href="/invoices" class="sidebar-item">
        <i class="fas fa-shopping-cart"></i> Ventes
      </a>
      <a href="/products" class="sidebar-item">
        <i class="fas fa-boxes"></i> Produits
      </a>
      <a href="/categories" class="sidebar-item">
        <i class="fas fa-check-square"></i> Catégories produits
      </a>
      <a href="/stocks" class="sidebar-item">
        <i class="fas fa-warehouse"></i> Rapport
      </a>
      <a href="/suppliers" class="sidebar-item">
        <i class="fas fa-truck-moving"></i> Fournisseurs
      </a>

      <a href="/orders" class="sidebar-item">
        <i class="fas fa-dolly"></i> Approvisionnement
      </a>
      <a href="/settings" class="sidebar-item">
        <i class="fas fa-cogs"></i> Paramètres
      </a>
    </div>
  </div>
  
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  
  <style>
    .sidebar {
      width: 250px;
      height: 100vh;
      background-color: #003366;
      color: white;
      padding-top: 20px;
      position: fixed; /* Make it fixed for responsive behavior */
      transition: transform 0.3s ease; /* Add transition for smooth animations */
    }
  
    .sidebar-heading {
      padding: 20px;
      background: #003366;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      border-bottom: 1px solid #fff;
    }
  
    .sidebar-menu {
      padding-top: 10px;
    }
  
    .sidebar-item {
      display: block;
      padding: 15px 20px;
      color: #fff;
      text-decoration: none;
      transition: background 0.3s ease;
    }
  
    .sidebar-item:hover {
      background-color: #0055b7;
      color: #fff;
      font-weight: 600;
      text-decoration: none;
    }
  
    .sidebar-item.active {
      background-color: white;
      color: #003366;
      font-weight: bold;
    }
  
    .sidebar-item i {
      width: 25px;
      margin-right: 10px;
    }
  
    /* Media queries for responsive behavior */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%); /* Hide sidebar initially on small screens */
      }
  
      .sidebar.active {
        transform: translateX(0); /* Show sidebar on click on small screens */
      }
    }
  </style>
  