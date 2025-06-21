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

export function AppSidebar({ ...props }: SidebarProps) {
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
      <SidebarHeader className="h-12 border-b text-xl font-bold">
        <Link href="/">NARSIL</Link>
      </SidebarHeader>
      <SidebarContent className="gap-0">
        {data.navMain.map((item) => (
          <SidebarMenu>
            <SidebarMenuItem key={item.title}>
              <SidebarMenuButton asChild>
                <Link href={item.url}>{item.title}</Link>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        ))}
      </SidebarContent>
      <SidebarRail />
    </Sidebar>
  );
}
