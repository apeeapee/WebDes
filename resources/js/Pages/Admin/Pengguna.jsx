import React, { useState } from 'react';
import { Head, useForm, usePage } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { 
    UserCog, Plus, Edit3, Trash2, X, CheckCircle2, ShieldCheck, Shield, 
    Mail, KeyRound, User, AlertCircle, Eye, EyeOff 
} from 'lucide-react';

export default function Pengguna({ items }) {
    const { auth } = usePage().props;
    const [showModal, setShowModal] = useState(false);
    const [editItem, setEditItem] = useState(null);
    const [showDeleteConfirm, setShowDeleteConfirm] = useState(null);
    const [showPassword, setShowPassword] = useState(false);

    const form = useForm({
        name: '',
        email: '',
        password: '',
        role: 'admin',
    });

    const openCreate = () => {
        setEditItem(null);
        form.reset();
        form.clearErrors();
        setShowPassword(false);
        setShowModal(true);
    };

    const openEdit = (item) => {
        setEditItem(item);
        form.setData({
            name: item.name,
            email: item.email,
            password: '',
            role: item.role,
        });
        form.clearErrors();
        setShowPassword(false);
        setShowModal(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (editItem) {
            form.put(`/admin/pengguna/${editItem.id}`, {
                onSuccess: () => {
                    setShowModal(false);
                    setEditItem(null);
                },
            });
        } else {
            form.post('/admin/pengguna', {
                onSuccess: () => {
                    setShowModal(false);
                },
            });
        }
    };

    const handleDelete = (id) => {
        form.delete(`/admin/pengguna/${id}`, {
            onSuccess: () => {
                setShowDeleteConfirm(null);
            },
        });
    };

    const getRoleBadge = (role) => {
        if (role === 'super_admin') {
            return (
                <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-300 uppercase tracking-wider">
                    <ShieldCheck className="h-3 w-3" />
                    Super Admin
                </span>
            );
        }
        return (
            <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-sky-100 text-sky-800 border border-sky-300 uppercase tracking-wider">
                <Shield className="h-3 w-3" />
                Admin
            </span>
        );
    };

    return (
        <AdminLayout title="Manajemen Pengguna" subtitle="Kelola akun administrator panel admin Desa Banyuurip">
            <Head title="Manajemen Pengguna - Admin Panel" />

            <div className="space-y-6">
                {/* Header Card */}
                <div className="rounded-2xl bg-white p-6 border border-sky-100 shadow-sm">
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span className="text-[10px] font-extrabold uppercase tracking-widest text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200">
                                Super Admin Only
                            </span>
                            <h2 className="text-base font-extrabold text-slate-900 mt-1">Daftar Akun Administrator</h2>
                            <p className="text-xs text-slate-500">Buat, edit, dan hapus akun admin untuk mengelola website Desa Banyuurip.</p>
                        </div>
                        <button
                            onClick={openCreate}
                            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold shadow-xs transition-all shrink-0 cursor-pointer"
                        >
                            <Plus className="h-3.5 w-3.5" />
                            <span>Tambah Admin Baru</span>
                        </button>
                    </div>
                </div>

                {/* Users Table */}
                <div className="rounded-2xl bg-white border border-sky-100 shadow-sm overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs min-w-[600px]">
                            <thead>
                                <tr className="bg-slate-950 text-white font-extrabold uppercase tracking-wider text-[11px]">
                                    <th className="py-3.5 px-5 rounded-tl-xl">#</th>
                                    <th className="py-3.5 px-5">Nama Lengkap</th>
                                    <th className="py-3.5 px-5">Email</th>
                                    <th className="py-3.5 px-5">Role</th>
                                    <th className="py-3.5 px-5">Dibuat</th>
                                    <th className="py-3.5 px-5 rounded-tr-xl text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-sky-50">
                                {(items || []).map((item, idx) => (
                                    <tr key={item.id} className="hover:bg-sky-50/40 transition-colors">
                                        <td className="py-3.5 px-5 font-bold text-slate-400">{idx + 1}</td>
                                        <td className="py-3.5 px-5">
                                            <div className="flex items-center gap-2.5">
                                                <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-100 text-sky-700 shrink-0">
                                                    <User className="h-4 w-4" />
                                                </div>
                                                <span className="font-bold text-slate-900">{item.name}</span>
                                            </div>
                                        </td>
                                        <td className="py-3.5 px-5 text-slate-600">{item.email}</td>
                                        <td className="py-3.5 px-5">{getRoleBadge(item.role)}</td>
                                        <td className="py-3.5 px-5 text-slate-500">{item.created_at || '-'}</td>
                                        <td className="py-3.5 px-5">
                                            <div className="flex items-center justify-center gap-2">
                                                <button
                                                    onClick={() => openEdit(item)}
                                                    className="p-1.5 rounded-lg text-sky-600 hover:bg-sky-100 transition-colors cursor-pointer"
                                                    title="Edit"
                                                >
                                                    <Edit3 className="h-4 w-4" />
                                                </button>
                                                {item.id !== auth?.user?.id && (
                                                    <button
                                                        onClick={() => setShowDeleteConfirm(item)}
                                                        className="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition-colors cursor-pointer"
                                                        title="Hapus"
                                                    >
                                                        <Trash2 className="h-4 w-4" />
                                                    </button>
                                                )}
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                                {(!items || items.length === 0) && (
                                    <tr>
                                        <td colSpan="6" className="py-12 text-center text-slate-400">
                                            <UserCog className="h-10 w-10 mx-auto text-slate-300 mb-2" />
                                            <p className="font-bold">Belum ada admin terdaftar.</p>
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* Total count */}
                <div className="text-xs text-slate-500 font-semibold text-right">
                    Total: {(items || []).length} akun admin terdaftar
                </div>
            </div>

            {/* Create / Edit Modal */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-950/60 backdrop-blur-xs">
                    <div className="w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
                        {/* Modal Header */}
                        <div className="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 text-white p-5 sm:p-6 flex items-start justify-between">
                            <div className="space-y-1">
                                <span className="text-[10px] font-extrabold uppercase tracking-widest text-sky-300 bg-sky-500/20 px-3 py-1 rounded-full border border-sky-400/30">
                                    {editItem ? 'Edit Admin' : 'Admin Baru'}
                                </span>
                                <h3 className="text-base font-extrabold mt-2">
                                    {editItem ? `Edit: ${editItem.name}` : 'Tambah Akun Admin'}
                                </h3>
                            </div>
                            <button
                                onClick={() => { setShowModal(false); setEditItem(null); }}
                                className="p-1.5 rounded-full bg-white/10 hover:bg-white/20 transition-colors cursor-pointer"
                            >
                                <X className="h-4 w-4" />
                            </button>
                        </div>

                        {/* Modal Form */}
                        <form onSubmit={handleSubmit} className="p-5 sm:p-6 space-y-4">
                            {/* Name */}
                            <div>
                                <label className="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                    Nama Lengkap <span className="text-rose-500">*</span>
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sky-600">
                                        <User className="h-4 w-4" />
                                    </div>
                                    <input
                                        type="text"
                                        required
                                        value={form.data.name}
                                        onChange={(e) => form.setData('name', e.target.value)}
                                        className="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-sky-200 bg-white text-sm placeholder-slate-400 focus:border-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500/20 transition-all shadow-xs"
                                        placeholder="Nama lengkap admin"
                                    />
                                </div>
                                {form.errors.name && <p className="mt-1 text-[11px] text-rose-600 font-semibold">{form.errors.name}</p>}
                            </div>

                            {/* Email */}
                            <div>
                                <label className="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                    Alamat Email <span className="text-rose-500">*</span>
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sky-600">
                                        <Mail className="h-4 w-4" />
                                    </div>
                                    <input
                                        type="email"
                                        required
                                        value={form.data.email}
                                        onChange={(e) => form.setData('email', e.target.value)}
                                        className="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-sky-200 bg-white text-sm placeholder-slate-400 focus:border-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500/20 transition-all shadow-xs"
                                        placeholder="email@banyuurip.desa.id"
                                    />
                                </div>
                                {form.errors.email && <p className="mt-1 text-[11px] text-rose-600 font-semibold">{form.errors.email}</p>}
                            </div>

                            {/* Password */}
                            <div>
                                <label className="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                    Kata Sandi {!editItem && <span className="text-rose-500">*</span>}
                                    {editItem && <span className="text-slate-400 normal-case tracking-normal font-medium ml-1">(kosongkan jika tidak ingin mengubah)</span>}
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sky-600">
                                        <KeyRound className="h-4 w-4" />
                                    </div>
                                    <input
                                        type={showPassword ? 'text' : 'password'}
                                        required={!editItem}
                                        value={form.data.password}
                                        onChange={(e) => form.setData('password', e.target.value)}
                                        className="block w-full pl-10 pr-10 py-2.5 rounded-xl border border-sky-200 bg-white text-sm placeholder-slate-400 focus:border-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500/20 transition-all shadow-xs"
                                        placeholder={editItem ? '••••••••' : 'Minimal 6 karakter'}
                                        minLength={form.data.password ? 6 : undefined}
                                    />
                                    <button
                                        type="button"
                                        onClick={() => setShowPassword(!showPassword)}
                                        className="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-sky-600 cursor-pointer"
                                    >
                                        {showPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
                                    </button>
                                </div>
                                {form.errors.password && <p className="mt-1 text-[11px] text-rose-600 font-semibold">{form.errors.password}</p>}
                            </div>

                            {/* Role */}
                            <div>
                                <label className="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                    Role Akses <span className="text-rose-500">*</span>
                                </label>
                                <div className="grid grid-cols-2 gap-3">
                                    <button
                                        type="button"
                                        onClick={() => form.setData('role', 'admin')}
                                        className={`flex items-center justify-center gap-2 p-3 rounded-xl border-2 text-xs font-bold transition-all cursor-pointer ${
                                            form.data.role === 'admin'
                                                ? 'border-sky-600 bg-sky-50 text-sky-800 shadow-sm'
                                                : 'border-slate-200 bg-white text-slate-500 hover:border-sky-300'
                                        }`}
                                    >
                                        <Shield className="h-4 w-4" />
                                        <span>Admin</span>
                                    </button>
                                    <button
                                        type="button"
                                        onClick={() => form.setData('role', 'super_admin')}
                                        className={`flex items-center justify-center gap-2 p-3 rounded-xl border-2 text-xs font-bold transition-all cursor-pointer ${
                                            form.data.role === 'super_admin'
                                                ? 'border-amber-500 bg-amber-50 text-amber-800 shadow-sm'
                                                : 'border-slate-200 bg-white text-slate-500 hover:border-amber-300'
                                        }`}
                                    >
                                        <ShieldCheck className="h-4 w-4" />
                                        <span>Super Admin</span>
                                    </button>
                                </div>
                                <p className="mt-2 text-[11px] text-slate-400">
                                    {form.data.role === 'super_admin' 
                                        ? '⚠️ Super Admin memiliki akses penuh termasuk kelola pengguna lain.'
                                        : 'Admin hanya memiliki akses kelola konten website.'
                                    }
                                </p>
                                {form.errors.role && <p className="mt-1 text-[11px] text-rose-600 font-semibold">{form.errors.role}</p>}
                            </div>

                            {/* Submit */}
                            <div className="pt-2 flex items-center justify-end gap-3">
                                <button
                                    type="button"
                                    onClick={() => { setShowModal(false); setEditItem(null); }}
                                    className="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-900 cursor-pointer"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    disabled={form.processing}
                                    className="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-500 hover:to-blue-500 text-white text-xs font-bold shadow-md transition-all cursor-pointer disabled:opacity-50"
                                >
                                    <CheckCircle2 className="h-3.5 w-3.5" />
                                    <span>{form.processing ? 'Menyimpan...' : (editItem ? 'Perbarui Admin' : 'Buat Akun Admin')}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* Delete Confirmation Modal */}
            {showDeleteConfirm && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-950/60 backdrop-blur-xs">
                    <div className="w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
                        <div className="p-6 text-center">
                            <div className="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-100 text-rose-600 mb-4">
                                <AlertCircle className="h-7 w-7" />
                            </div>
                            <h3 className="text-base font-extrabold text-slate-900">Hapus Akun Admin?</h3>
                            <p className="mt-2 text-xs text-slate-500 leading-relaxed">
                                Akun <strong className="text-slate-900">{showDeleteConfirm.name}</strong> ({showDeleteConfirm.email}) akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                        <div className="flex border-t border-slate-100">
                            <button
                                onClick={() => setShowDeleteConfirm(null)}
                                className="flex-1 py-3.5 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors cursor-pointer border-r border-slate-100"
                            >
                                Batal
                            </button>
                            <button
                                onClick={() => handleDelete(showDeleteConfirm.id)}
                                className="flex-1 py-3.5 text-xs font-bold text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                            >
                                Ya, Hapus Akun
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
