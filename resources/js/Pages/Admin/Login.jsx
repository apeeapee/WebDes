import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';
import { Lock, Mail, KeyRound, LogIn, AlertCircle, ShieldCheck } from 'lucide-react';

export default function Login({ errors }) {
    const { data, setData, post, processing } = useForm({
        email: '',
        password: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/admin/login');
    };

    return (
        <MainLayout>
            <Head title="Login Perangkat Desa" />

            <div class="min-h-[80vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 bg-banyu-grid relative">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(2,132,199,0.1),transparent_70%)] animate-pulse-glow"></div>
                
                <div class="w-full max-w-md space-y-8 glass-panel-banyu p-8 sm:p-10 rounded-3xl shadow-2xl border border-sky-200/80 relative z-10 banyu-hover-card">
                    <div class="text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white p-2 shadow-lg shadow-sky-500/20 border border-sky-100 animate-float">
                            <img src="/images/logo-boyolali.jpg" alt="Logo Boyolali" class="h-12 w-auto object-contain" />
                        </div>
                        <h2 class="mt-5 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                            Login Admin Desa
                        </h2>
                        <p class="mt-2 text-xs text-sky-700 font-semibold">
                            Pintu gerbang tata kelola digital Desa Banyuurip
                        </p>
                    </div>

                    {Object.keys(errors).length > 0 && (
                        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                            {Object.values(errors).map((err, idx) => (
                                <div key={idx} class="flex items-center gap-2">
                                    <AlertCircle class="h-4 w-4 text-rose-600 shrink-0" />
                                    <span>{err}</span>
                                </div>
                            ))}
                        </div>
                    )}

                    <form class="mt-8 space-y-6" onSubmit={handleSubmit}>
                        <div class="space-y-4">
                            <div>
                                <label htmlFor="email" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Alamat Email Perangkat</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sky-600">
                                        <Mail class="h-4 w-4" />
                                    </div>
                                    <input 
                                        id="email" 
                                        type="email" 
                                        required 
                                        value={data.email}
                                        onChange={(e) => setData('email', e.target.value)}
                                        class="block w-full pl-10 pr-4 py-3.5 rounded-xl border border-sky-200 bg-white text-sm placeholder-slate-400 focus:border-sky-600 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 transition-all shadow-xs"
                                        placeholder="admin@banyuurip.desa.id" 
                                    />
                                </div>
                            </div>
                            <div>
                                <label htmlFor="password" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Kata Sandi</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sky-600">
                                        <KeyRound class="h-4 w-4" />
                                    </div>
                                    <input 
                                        id="password" 
                                        type="password" 
                                        required 
                                        value={data.password}
                                        onChange={(e) => setData('password', e.target.value)}
                                        class="block w-full pl-10 pr-4 py-3.5 rounded-xl border border-sky-200 bg-white text-sm placeholder-slate-400 focus:border-sky-600 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 transition-all shadow-xs"
                                        placeholder="••••••••" 
                                    />
                                </div>
                            </div>
                        </div>

                        <div>
                            <button 
                                type="submit" 
                                disabled={processing}
                                class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-xs font-bold rounded-xl text-white bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-500 hover:to-blue-500 focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all shadow-lg shadow-sky-600/25 cursor-pointer disabled:opacity-50 hover:scale-[1.02]"
                            >
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3.5">
                                    <LogIn class="h-4 w-4 text-sky-200 group-hover:text-white transition-colors" />
                                </span>
                                {processing ? 'Memproses Authentikasi...' : 'Masuk Dashboard Admin'}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </MainLayout>
    );
}
