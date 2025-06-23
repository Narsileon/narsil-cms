import { Link } from "@inertiajs/react";
import { useRoute } from "ziggy-js";
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
import AppLogo from "./app-logo";

function AppSidebar({ ...props }: SidebarProps) {
  const route = useRoute();

  const data = {
    versions: ["1.0.1", "1.1.0-alpha", "2.0.0-beta1"],
    navMain: [
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
              <SidebarMenuButton asChild>
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
