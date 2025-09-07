import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useNavigation } from "@narsil-cms/hooks/use-props";
import {
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarRail,
  SidebarRoot,
  useSidebar,
} from "@narsil-cms/components/ui/sidebar";

type SidebarProps = React.ComponentProps<typeof SidebarRoot> & {};

function Sidebar({ ...props }: SidebarProps) {
  const { trans } = useLabels();

  const { open, setOpenMobile, toggleSidebar } = useSidebar();

  const { sidebar } = useNavigation();

  return (
    <SidebarRoot collapsible="icon" {...props}>
      <SidebarHeader className="h-13 border-b">
        <SidebarMenuButton className="truncate" asChild={true}>
          <Link href={route("dashboard")}>
            <svg width={20} height={20}>
              <use href="/favicon.svg" width={20} height={20}></use>
            </svg>
            CMS
          </Link>
        </SidebarMenuButton>
      </SidebarHeader>
      <SidebarContent>
        <SidebarMenu>
          {sidebar?.content.map((item, index) => {
            if (item.children) {
              return (
                <SidebarGroup key={index}>
                  <SidebarGroupLabel>{item.label}</SidebarGroupLabel>
                  <SidebarGroupContent>
                    {item.children.map((child, childIndex) => {
                      return (
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
                              <Icon name={child.icon} />
                              {child.label}
                            </Link>
                          </SidebarMenuButton>
                        </SidebarMenuItem>
                      );
                    })}
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
                    <Icon name={item.icon} />
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
          tooltip={trans("accessibility.open_sidebar")}
          onClick={toggleSidebar}
        >
          <Icon
            className={cn("duration-300", open && "rotate-180")}
            name="chevron-left"
          />
          {open && trans("accessibility.close_sidebar")}
        </SidebarMenuButton>
      </SidebarFooter>
      <SidebarRail />
    </SidebarRoot>
  );
}

export default Sidebar;
