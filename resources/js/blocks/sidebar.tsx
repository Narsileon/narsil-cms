import { Link } from "@inertiajs/react";
import { groupBy } from "lodash";
import { type ComponentProps } from "react";
import { route } from "ziggy-js";

import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
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
} from "@narsil-cms/components/sidebar";
import { useNavigation } from "@narsil-cms/hooks/use-props";
import { cn } from "@narsil-cms/lib/utils";

type SidebarProps = ComponentProps<typeof SidebarRoot>;

function Sidebar({ ...props }: SidebarProps) {
  const { trans } = useLocalization();

  const { open, setOpenMobile, toggleSidebar } = useSidebar();

  const { sidebar } = useNavigation();

  const groupedMenu = groupBy(sidebar, (item) => {
    return item.group ?? `_${item.label}`;
  });

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
          {Object.entries(groupedMenu)?.map(([group, items], groupIndex) => {
            return group.startsWith("_") ? (
              <SidebarMenuItem key={groupIndex}>
                <SidebarMenuButton
                  asChild
                  isActive={items[0].href?.endsWith(window.location.pathname)}
                  tooltip={items[0].label}
                >
                  <Link
                    href={items[0].href}
                    onSuccess={() => setOpenMobile(false)}
                  >
                    {items[0].icon ? <Icon name={items[0].icon} /> : null}
                    {items[0].label}
                  </Link>
                </SidebarMenuButton>
              </SidebarMenuItem>
            ) : (
              <SidebarGroup key={groupIndex}>
                <SidebarGroupLabel>{group}</SidebarGroupLabel>
                <SidebarGroupContent>
                  {items.map((item, itemIndex) => {
                    return (
                      <SidebarMenuItem key={itemIndex}>
                        <SidebarMenuButton
                          asChild
                          isActive={item.href.endsWith(
                            window.location.pathname,
                          )}
                          tooltip={item.label}
                        >
                          <Link
                            href={item.href}
                            onSuccess={() => setOpenMobile(false)}
                          >
                            {item.icon ? <Icon name={item.icon} /> : null}
                            {item.label}
                          </Link>
                        </SidebarMenuButton>
                      </SidebarMenuItem>
                    );
                  })}
                </SidebarGroupContent>
              </SidebarGroup>
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
