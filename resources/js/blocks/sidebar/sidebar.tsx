import { Icon } from "@narsil-cms/blocks/icon";
import { Link } from "@narsil-cms/blocks/link";
import { Button } from "@narsil-cms/components/button";
import { useLocalization } from "@narsil-cms/components/localization";
import {
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuItem,
  SidebarRail,
  SidebarRoot,
  useSidebar,
} from "@narsil-cms/components/sidebar";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { useNavigation } from "@narsil-cms/hooks/use-props";
import { cn } from "@narsil-cms/lib/utils";
import { groupBy } from "lodash-es";
import { type ComponentProps } from "react";
import { route } from "ziggy-js";

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
        <Button
          className="truncate"
          variant="sidebar"
          render={
            <Link href={route("dashboard")}>
              <Icon name="narsil" />
              CMS
            </Link>
          }
        />
      </SidebarHeader>
      <SidebarContent>
        <SidebarMenu>
          {Object.entries(groupedMenu)?.map(([group, items], groupIndex) => {
            return group.startsWith("_") ? (
              <SidebarMenuItem key={groupIndex}>
                <Tooltip tooltip={items[0].label}>
                  <Button
                    aria-label={items[0].label}
                    data-active={items[0].href?.endsWith(window.location.pathname)}
                    variant="sidebar"
                    render={
                      <Link
                        href={items[0].href}
                        target={items[0].target}
                        onSuccess={() => setOpenMobile(false)}
                      >
                        {items[0].icon ? <Icon name={items[0].icon} /> : null}
                        {items[0].label}
                      </Link>
                    }
                  />
                </Tooltip>
              </SidebarMenuItem>
            ) : (
              <SidebarGroup key={groupIndex}>
                <SidebarGroupLabel>{group}</SidebarGroupLabel>
                <SidebarGroupContent>
                  {items.map((item, itemIndex) => {
                    return (
                      <SidebarMenuItem key={itemIndex}>
                        <Tooltip tooltip={item.label}>
                          <Button
                            aria-label={item.label}
                            data-active={item.href.endsWith(window.location.pathname)}
                            variant="sidebar"
                            render={
                              <Link
                                href={item.href}
                                target={item.target}
                                {...(item.target !== "_blank"
                                  ? { onSuccess: () => setOpenMobile(false) }
                                  : {})}
                              >
                                {item.icon ? <Icon name={item.icon} /> : null}
                                {item.label}
                              </Link>
                            }
                          />
                        </Tooltip>
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
        <Tooltip tooltip={trans("accessibility.toggle_sidebar")}>
          <Button onClick={toggleSidebar} variant="sidebar">
            <Icon className={cn("duration-300", open && "rotate-180")} name="chevron-left" />
            {open && trans("accessibility.close_sidebar")}
          </Button>
        </Tooltip>
      </SidebarFooter>
      <SidebarRail />
    </SidebarRoot>
  );
}

export default Sidebar;
