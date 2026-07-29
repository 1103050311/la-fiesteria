import { Link, usePage } from '@inertiajs/react';
import {
    Archive,
    BarChart,
    CalendarDays,
    ClipboardList,
    Image,
    LayoutGrid,
    Tag,
    Box,
} from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { TeamSwitcher } from '@/components/team-switcher';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

export function AppSidebar() {
    const page = usePage();
    const teamBaseUrl = page.props.currentTeam ? `/${page.props.currentTeam.slug}` : '';
    const dashboardUrl = page.props.currentTeam
        ? dashboard(page.props.currentTeam.slug)
        : '/';
    const inventarioUrl = teamBaseUrl ? `${teamBaseUrl}/inventario` : '/';
    const productosUrl = teamBaseUrl ? `${teamBaseUrl}/productos` : '/';
    const categoriasUrl = teamBaseUrl ? `${teamBaseUrl}/categorias` : '/';
    const solicitudesUrl = teamBaseUrl ? `${teamBaseUrl}/solicitudes` : '/';
    const reservasUrl = teamBaseUrl ? `${teamBaseUrl}/reservas` : '/';
    const galeriaUrl = teamBaseUrl ? `${teamBaseUrl}/galeria` : '/';
    const reportesUrl = teamBaseUrl ? `${teamBaseUrl}/reportes` : '/';


    const mainNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            href: dashboardUrl,
            icon: LayoutGrid,
        },
        {
            title: 'Inventario',
            href: inventarioUrl,
            icon: Archive,
        },
        {
            title: 'Productos',
            href: productosUrl,
            icon: Box,
        },
        {
            title: 'Categorias',
            href: categoriasUrl,
            icon: Tag,
        },
        {
            title: 'Solicitudes',
            href: solicitudesUrl,
            icon: ClipboardList,
        },
        {
            title: 'Reservas',
            href: reservasUrl,
            icon: CalendarDays,
        },
        {
            title: 'Galeria',
            href: galeriaUrl,
            icon: Image,
        },
        {
            title: 'Reportes',
            href: reportesUrl,
            icon: BarChart,
        },
    ];

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboardUrl} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <TeamSwitcher />
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
