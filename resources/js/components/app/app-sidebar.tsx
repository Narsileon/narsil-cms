import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import AppLogo from "./app-logo";
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

function AppSidebar({ ...props }: SidebarProps) {
  const data = {
    versions: ["1.0.1", "1.1.0-alpha", "2.0.0-beta1"],
    navMain: [
      {
        title: "Users",
        url: route("users.index"),
      },
      {
        title: "Settings",
        url: route("settings"),
      },
    ],
  };

  return (
    <Sidebar {...props}>
      <SidebarHeader className="h-12 border-b">
        <AppLogo />
      </SidebarHeader>
      <SidebarContent className="gap-0">
        <SidebarMenu>
          {data.navMain.map((item) => (
            <SidebarMenuItem key={item.title}>
              <SidebarMenuButton asChild={true}>
                <Link href={item.url}>{item.title}</Link>
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
