import React from 'react';

export default function MaterialIcon({ name, size = 20, className = '' }) {
  return <span className={`material-symbols-rounded ${className}`} style={{ fontSize: size }} aria-hidden="true">{name}</span>;
}
