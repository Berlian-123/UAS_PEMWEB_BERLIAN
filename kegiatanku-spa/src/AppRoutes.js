// src/AppRoutes.js
import React from "react";
import { Routes, Route, Navigate } from "react-router-dom";
import Dashboard from "./pages/Dashboard";
import KegiatanIndex from "./pages/KegiatanIndex";
import KegiatanCreate from "./pages/KegiatanCreate"; 
import KegiatanEdit from "./pages/KegiatanEdit";
import LoginPage from "./pages/LoginPage";

import ComponentHeader from "./components/ComponentHeader";
import ComponentFooter from "./components/ComponentFooter";
import ComponentSideBar from "./components/ComponentSideBar";

const isLoggedIn = () => localStorage.getItem("isLoggedIn") === "true";

const MainLayout = ({ children }) => (
  <div id="wrapper">
    <ComponentSideBar />
    <div id="content-wrapper" className="d-flex flex-column">
      <div id="content">
        <ComponentHeader />
        {children}
      </div>
      <ComponentFooter />
    </div>
  </div>
);

const PrivateRoute = (props) =>
  isLoggedIn() ? <MainLayout>{props.element}</MainLayout> : <Navigate to="/login" replace />;

const AppRoutes = () => (
  <Routes>
    {/* halaman login */}
    <Route
      path="/login"
      element={
        isLoggedIn()
          ? <Navigate to="/" replace />
          : <LoginPage onLogin={() => window.location.href = "/"} />
      }
    />

    {/* halaman setelah login */}
    <Route path="/"               element={<PrivateRoute element={<Dashboard />} />} />
    <Route path="/kegiatan"       element={<PrivateRoute element={<KegiatanIndex />} />} />
    <Route path="/kegiatan/create" element={<PrivateRoute element={<KegiatanCreate />} />} />
    <Route path="/kegiatan/edit/:id" element={<PrivateRoute element={<KegiatanEdit />} />}/>


    {/* fallback */}
    <Route path="*" element={<Navigate to="/" replace />} />
  </Routes>
);

export default AppRoutes;
