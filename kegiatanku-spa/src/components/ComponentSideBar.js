import React from 'react';
import { NavLink } from 'react-router-dom';

function ComponentSideBar() {
  return (
    <ul className="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      {/* Sidebar Brand */}
      <a className="sidebar-brand d-flex align-items-center justify-content-center" href="/#">
        <div className="sidebar-brand-icon rotate-n-15">
          <i className="fas fa-book-open"></i>
        </div>
        <div className="sidebar-brand-text mx-3">Kegiatanku</div>
      </a>

      <hr className="sidebar-divider my-0" />

      {/* Dashboard */}
      <li className="nav-item">
        <NavLink exact to="/" className="nav-link" activeClassName="active">
          <i className="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </NavLink>
      </li>

      <hr className="sidebar-divider" />
      <li className="nav-item">
        <a
          className="nav-link collapsed"
          href="/#"
          data-toggle="collapse"
          data-target="#masterSection"
          aria-expanded="true"
          aria-controls="masterSection"
        >
          <i className="fas fa-fw fa-folder"></i>
          <span>Manajemen</span>
        </a>

        <div id="masterSection" className="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div className="bg-white py-2 collapse-inner rounded">
           
            <NavLink to="/kegiatan" className="collapse-item" activeClassName="active">Kegiatan</NavLink>
          </div>
        </div>
      </li>

      <hr className="sidebar-divider d-none d-md-block" />

    </ul>
  );
}

export default ComponentSideBar;
