import React from "react";
import { HashRouter, Routes, Route, Navigate } from "react-router-dom";

import LoginPage from "./pages/LoginPage";
import Dashboard from "./pages/Dashboard";
import KegiatanIndex from "./pages/KegiatanIndex";
import KegiatanCreate from "./pages/KegiatanCreate";
import KegiatanEdit from "./pages/KegiatanEdit";

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

const PrivateRoute = ({ element }) =>
  isLoggedIn() ? <MainLayout>{element}</MainLayout> : <Navigate to="/login" replace />;

function App() {
  return (
    <HashRouter>
      <Routes>
        <Route
          path="/login"
          element={
            isLoggedIn() ? <Navigate to="/" replace /> : <LoginPage />
          }
        />
        <Route path="/" element={<PrivateRoute element={<Dashboard />} />} />
        <Route path="/kegiatan" element={<PrivateRoute element={<KegiatanIndex />} />} />
        <Route path="/kegiatan/create" element={<PrivateRoute element={<KegiatanCreate />} />} />
        <Route path="/kegiatan/edit/:id" element={<PrivateRoute element={<KegiatanEdit />} />} />
        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </HashRouter>
  );
}

export default App;
