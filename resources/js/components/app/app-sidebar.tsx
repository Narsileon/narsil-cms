import { ChevronLeftIcon, ChevronRightIcon } from "lucide-react";
import { DynamicIcon } from "lucide-react/dynamic";
import { Link, usePage } from "@inertiajs/react";
import { route } from "ziggy-js";
import useTranslationsStore from "@/stores/translations-store";
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
import type { GlobalProps } from "@/types/global";

type AppSidebarProps = React.ComponentProps<typeof Sidebar> & {};

function AppSidebar({ ...props }: AppSidebarProps) {
  const { trans } = useTranslationsStore();

  const { open, setOpenMobile, toggleSidebar } = useSidebar();

  const sidebar = usePage<GlobalProps>().props.config.sidebar ?? {};

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
            {sidebar.content.map((item, index) => (
              <SidebarMenuItem key={index}>
                <SidebarMenuButton
                  asChild={true}
                  tooltip={trans(item.label, item.label)}
                >
                  <Link
                    href={route(item.route)}
                    onSuccess={() => {
                      setOpenMobile(false);
                    }}
                  >
                    <DynamicIcon name={item.icon} />
                    {trans(item.label, item.label)}
                  </Link>
                </SidebarMenuButton>
              </SidebarMenuItem>
            ))}
          </SidebarMenu>
        </SidebarGroup>
      </SidebarContent>
      <SidebarFooter className="border-t">
        <SidebarMenuButton
          tooltip={trans("accessibility.open_sidebar", "Open sidebar")}
          onClick={toggleSidebar}
        >
          {open ? (
            <>
              <ChevronLeftIcon />
              {trans("accessibility.close_sidebar", "Close sidebar")}
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
