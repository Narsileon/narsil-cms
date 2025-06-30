import { Link, usePage } from "@inertiajs/react";
import { route } from "ziggy-js";
import AppLogo from "./app-logo";
import useTranslationsStore from "@/stores/translations-store";
import {
  Sidebar,
  SidebarContent,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarProps,
  SidebarRail,
} from "@/components/ui/sidebar";
import type { GlobalProps } from "@/types/global";
import { DynamicIcon } from "lucide-react/dynamic";

function AppSidebar({ ...props }: SidebarProps) {
  const { trans } = useTranslationsStore();

  const sidebar = usePage<GlobalProps>().props.config.sidebar ?? {};

  return (
    <Sidebar {...props}>
      <SidebarHeader className="h-12 border-b">
        <AppLogo />
      </SidebarHeader>
      <SidebarContent className="gap-0">
        <SidebarMenu>
          {sidebar.content.map((item, index) => (
            <SidebarMenuItem key={index}>
              <SidebarMenuButton asChild={true}>
                <Link href={route(item.route)}>
                  <DynamicIcon name={item.icon} />
                  {trans(item.label, item.label)}
                </Link>
              </SidebarMenuButton>
            </SidebarMenuItem>
          ))}
        </SidebarMenu>
      </SidebarContent>
      <SidebarRail />
    </Sidebar>
  );
}

export default AppSidebar;
