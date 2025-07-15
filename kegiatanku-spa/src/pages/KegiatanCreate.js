// src/pages/KegiatanCreate.js
import React, { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import axios from "axios";

const KegiatanCreate = () => {
  const navigate = useNavigate();

  const [kegiatanData, setKegiatanData] = useState({
    judul: "",
    deskripsi: "",
    tanggal: "",
    status: "belum"
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setKegiatanData({ ...kegiatanData, [name]: value });
  };

  const handleSubmit = (event) => {
    event.preventDefault();

    axios.post("http://localhost:8000/api/kegiatans", kegiatanData)
      .then(response => {
        alert("Kegiatan berhasil ditambahkan!");
        navigate("/kegiatan");
      })
      .catch(error => {
        console.error("Gagal menyimpan kegiatan:", error);
        alert("Gagal menyimpan kegiatan");
      });
  };

  return (
    <div className="container-fluid">
      <h1 className="h3 text-gray-800 mb-4">Tambah Kegiatan</h1>
      <Link to="/kegiatan" className="btn btn-secondary mb-3">Kembali</Link>
      <div className="card shadow">
        <div className="card-body">
          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label>Judul</label>
              <input
                type="text"
                name="judul"
                value={kegiatanData.judul}
                onChange={handleInputChange}
                className="form-control"
                required
              />
            </div>
            <div className="form-group">
              <label>Deskripsi</label>
              <textarea
                name="deskripsi"
                value={kegiatanData.deskripsi}
                onChange={handleInputChange}
                className="form-control"
                required
              ></textarea>
            </div>
            <div className="form-group">
              <label>Tanggal</label>
              <input
                type="date"
                name="tanggal"
                value={kegiatanData.tanggal}
                onChange={handleInputChange}
                className="form-control"
                required
              />
            </div>
            <div className="form-group">
              <label>Status</label>
              <select
                name="status"
                value={kegiatanData.status}
                onChange={handleInputChange}
                className="form-control"
                required
              >
                <option value="belum">Belum</option>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
              </select>
            </div>
            <button type="submit" className="btn btn-success mt-3">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  );
};

export default KegiatanCreate;
