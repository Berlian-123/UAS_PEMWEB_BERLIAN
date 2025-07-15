// src/components/ComponentHeader.js
import React from "react";
import { useNavigate } from "react-router-dom";

const ComponentHeader = () => {
  const navigate = useNavigate();

  const handleLogout = () => {
    localStorage.removeItem("isLoggedIn");
    navigate("/login", { replace: true });
  };

  return (
    <nav className="navbar navbar-light bg-white topbar mb-4 static-top shadow">
      <h5 className="mb-0 font-weight-bold text-primary">Kegiatanku App</h5>
      <button
        onClick={handleLogout}
        className="btn btn-outline-danger btn-sm ml-auto"
      >
        <i className="fas fa-sign-out-alt mr-1" /> Logout
      </button>
    </nav>
  );
};

export default ComponentHeader;
