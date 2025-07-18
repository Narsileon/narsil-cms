import { ChevronLeftIcon, ChevronRightIcon } from "lucide-react";
import { DynamicIcon } from "lucide-react/dynamic";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { useLabels } from "@/components/ui/labels";
import { useNavigation } from "@/hooks/use-props";
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarRail,
  useSidebar,
} from "@/components/ui/sidebar";

type AppSidebarProps = React.ComponentProps<typeof Sidebar> & {};

function AppSidebar({ ...props }: AppSidebarProps) {
  const { getLabel } = useLabels();

  const { open, setOpenMobile, toggleSidebar } = useSidebar();

  const { sidebar } = useNavigation();

  return (
    <Sidebar collapsible="icon" {...props}>
      <SidebarHeader className="h-12 border-b">
        <SidebarMenuButton className="truncate" asChild={true}>
          <Link href={route("home")}>
            <img src="/favicon.svg" width={20} height={20} />
            CMS
          </Link>
        </SidebarMenuButton>
      </SidebarHeader>
      <SidebarContent className="gap-0">
        <SidebarGroup>
          <SidebarMenu>
            {sidebar?.content.map((item, index) => (
              <SidebarMenuItem key={index}>
                <SidebarMenuButton asChild={true} tooltip={item.label}>
                  <Link
                    href={item.href}
                    onSuccess={() => {
                      setOpenMobile(false);
                    }}
                  >
                    <DynamicIcon name={item.icon} />
                    {item.label}
                  </Link>
                </SidebarMenuButton>
              </SidebarMenuItem>
            ))}
          </SidebarMenu>
        </SidebarGroup>
      </SidebarContent>
      <SidebarFooter className="border-t">
        <SidebarMenuButton
          tooltip={getLabel("accessibility.open_sidebar")}
          onClick={toggleSidebar}
        >
          {open ? (
            <>
              <ChevronLeftIcon />
              {getLabel("accessibility.close_sidebar")}
            </>
          ) : (
            <ChevronRightIcon />
          )}
        </SidebarMenuButton>
      </SidebarFooter>
      <SidebarRail />
    </Sidebar>
  );
}

export default AppSidebar;
