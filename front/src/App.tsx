import React from 'react';

import './styles.globals.css';
import Header from '@/shared/components/layout/header';
import Home from '@/features/calls/components/views/home'

export default function App() {
  return (
    <div className="container">
      <Header />

      <Home />
    </div>
  );
}