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
    const dashboardUrl = page.props.currentTeam
        ? dashboard(page.props.currentTeam.slug)
        : '/';

    const mainNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            href: dashboardUrl,
            icon: LayoutGrid,
        },
        {
            title: 'Inventario',
            href: '/inventario',
            icon: Archive,
        },
        {
            title: 'Productos',
            href: '/Productos',
            icon: Box,
        },
        {
            title: 'Categorias',
            href: '/Categorias',
            icon: Tag,
        },
        {
            title: 'Solicitudes',
            href: '/Solicitudes',
            icon: ClipboardList,
        },
        {
            title: 'Reservas',
            href: '/Reservas',
            icon: CalendarDays,
        },
        {
            title: 'Galeria',
            href: '/Galeria',
            icon: Image,
        },
        {
            title: 'Reportes',
            href: '/Reportes',
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
