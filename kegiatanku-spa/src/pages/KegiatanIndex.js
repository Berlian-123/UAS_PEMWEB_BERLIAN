// src/pages/KegiatanIndex.js

import React, { useState, useEffect } from "react";
import axios from "axios";
import { Link } from "react-router-dom";

const KegiatanIndex = () => {
  const [kegiatans, setKegiatans] = useState([]);

  const loadKegiatans = () => {
    axios
      .get("http://localhost:8000/api/kegiatans")
      .then((response) => {
        setKegiatans(response.data.data);
      })
      .catch((error) => {
        alert("Error fetching data: " + error.message);
      });
  };

  const handleDelete = (id) => {
    if (window.confirm("Yakin ingin menghapus kegiatan ini?")) {
      axios.delete(`http://localhost:8000/api/kegiatans/${id}`)
        .then(() => {
          alert("Kegiatan berhasil dihapus");
          loadKegiatans();
        })
        .catch((error) => {
          alert("Gagal menghapus kegiatan: " + error.message);
        });
    }
  };

  useEffect(() => {
    loadKegiatans();
  }, []);

  return (
    <div className="container-fluid">
      <h1 className="h3 text-gray-800 mb-2">Data Kegiatan</h1>

      <Link to="/kegiatan/create" className="btn btn-primary mb-3">
        Tambah Kegiatan
      </Link>

      <div className="card shadow mb-4">
        <div className="card-body">
          <div className="table-responsive">
            <table className="table table-bordered" width="100%" cellSpacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Judul</th>
                  <th>Deskripsi</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {kegiatans.length === 0 ? (
                  <tr>
                    <td colSpan="6" className="text-center">
                      Tidak ada data.
                    </td>
                  </tr>
                ) : (
                  kegiatans.map((item, index) => (
                    <tr key={index}>
                      <td>{item.id}</td>
                      <td>{item.judul}</td>
                      <td>{item.deskripsi}</td>
                      <td>{item.tanggal}</td>
                      <td>
                        <span className={`badge badge-${item.status === 'selesai' ? 'success' : item.status === 'proses' ? 'warning' : 'secondary'}`}>
                          {item.status}
                        </span>
                      </td>
                      <td>
                        <Link
                          to={`/kegiatan/edit/${item.id}`}
                          className="btn btn-sm btn-info"
                        >
                          Edit
                        </Link>
                        <button
                          onClick={() => handleDelete(item.id)}
                          className="btn btn-sm btn-danger ml-2"
                        >
                          Hapus
                        </button>
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  );
};

export default KegiatanIndex;
