import { ChevronLeftIcon, ChevronRightIcon } from "lucide-react";
import { DynamicIcon } from "lucide-react/dynamic";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useNavigation } from "@narsil-cms/hooks/use-props";
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupLabel,
  SidebarGroupContent,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarRail,
  useSidebar,
} from "@narsil-cms/components/ui/sidebar";

type AppSidebarProps = React.ComponentProps<typeof Sidebar> & {};

function AppSidebar({ ...props }: AppSidebarProps) {
  const { getLabel } = useLabels();

  const { open, setOpenMobile, toggleSidebar } = useSidebar();

  const { sidebar } = useNavigation();

  console.log(sidebar);
  return (
    <Sidebar collapsible="icon" {...props}>
      <SidebarHeader className="h-13 border-b">
        <SidebarMenuButton className="truncate" asChild={true}>
          <Link href={route("home")}>
            <svg width={20} height={20}>
              <use href="/favicon.svg" width={20} height={20}></use>
            </svg>
            CMS
          </Link>
        </SidebarMenuButton>
      </SidebarHeader>
      <SidebarContent className="gap-0">
        <SidebarMenu>
          {sidebar?.content.map((item, index) => {
            if (item.children?.length > 0) {
              return (
                <SidebarGroup key={index}>
                  <SidebarGroupLabel>{item.label}</SidebarGroupLabel>
                  <SidebarGroupContent>
                    {item.children.map((child, childIndex) => (
                      <SidebarMenuItem key={childIndex}>
                        <SidebarMenuButton
                          asChild
                          isActive={child.href.endsWith(
                            window.location.pathname,
                          )}
                          tooltip={child.label}
                        >
                          <Link
                            href={child.href}
                            onSuccess={() => setOpenMobile(false)}
                          >
                            <DynamicIcon name={child.icon} />
                            {child.label}
                          </Link>
                        </SidebarMenuButton>
                      </SidebarMenuItem>
                    ))}
                  </SidebarGroupContent>
                </SidebarGroup>
              );
            }

            return (
              <SidebarMenuItem key={index}>
                <SidebarMenuButton
                  asChild
                  isActive={item.href?.endsWith(window.location.pathname)}
                  tooltip={item.label}
                >
                  <Link href={item.href} onSuccess={() => setOpenMobile(false)}>
                    <DynamicIcon name={item.icon} />
                    {item.label}
                  </Link>
                </SidebarMenuButton>
              </SidebarMenuItem>
            );
          })}
        </SidebarMenu>
      </SidebarContent>
      <SidebarFooter className="h-13 border-t">
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
