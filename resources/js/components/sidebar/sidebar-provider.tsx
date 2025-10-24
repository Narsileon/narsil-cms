import { cn } from "@narsil-cms/lib/utils";
import { useCallback, useEffect, useMemo, useState, type ComponentProps } from "react";
import { SidebarContext, type SidebarContextProps } from "./sidebar-context";

type SidebarProviderProps = ComponentProps<"div"> & {
  cookieMaxAge?: number;
  cookieName?: string;
  defaultOpen?: boolean;
  iconWidth?: string;
  isMobile?: boolean;
  keyboardShortcut?: string;
  mobileWidth?: string;
  open?: boolean;
  width?: string;
  onOpenChange?: (open: boolean) => void;
};

function SidebarProvider({
  children,
  className,
  cookieMaxAge = 60 * 60 * 24 * 7,
  cookieName = "sidebar_state",
  defaultOpen = true,
  iconWidth = "3.25rem",
  isMobile = false,
  keyboardShortcut = "b",
  mobileWidth = "18rem",
  onOpenChange: setOpenProp,
  open: openProp,
  style,
  width = "14rem",
  ...props
}: SidebarProviderProps) {
  const [_open, _setOpen] = useState(defaultOpen);
  const [openMobile, setOpenMobile] = useState(false);

  const open = openProp ?? _open;

  const setOpen = useCallback(
    (value: boolean | ((value: boolean) => boolean)) => {
      const openState = typeof value === "function" ? value(open) : value;
      if (setOpenProp) {
        setOpenProp(openState);
      } else {
        _setOpen(openState);
      }

      document.cookie = `${cookieName}=${openState}; path=/; max-age=${cookieMaxAge}`;
    },
    [setOpenProp, open],
  );

  const toggleSidebar = useCallback(() => {
    return isMobile ? setOpenMobile((open) => !open) : setOpen((open) => !open);
  }, [isMobile, setOpen, setOpenMobile]);

  useEffect(() => {
    const handleKeyDown = (e: KeyboardEvent) => {
      if (e.key === keyboardShortcut && (e.metaKey || e.ctrlKey)) {
        e.preventDefault();

        toggleSidebar();
      }
    };

    window.addEventListener("keydown", handleKeyDown);

    return () => {
      return window.removeEventListener("keydown", handleKeyDown);
    };
  }, [toggleSidebar]);

  const state = open ? "expanded" : "collapsed";

  const contextValue = useMemo<SidebarContextProps>(
    () => ({
      isMobile: isMobile,
      mobileWidth: mobileWidth,
      open: open,
      openMobile: openMobile,
      state: state,
      setOpen: setOpen,
      setOpenMobile: setOpenMobile,
      toggleSidebar: toggleSidebar,
    }),
    [isMobile, mobileWidth, open, openMobile, state, setOpen, setOpenMobile, toggleSidebar],
  );

  return (
    <SidebarContext.Provider value={contextValue}>
      <div
        data-slot="sidebar-wrapper"
        className={cn(
          "group/sidebar-wrapper flex min-h-svh w-full has-data-[variant=inset]:bg-sidebar",
          className,
        )}
        style={
          {
            "--sidebar-width": width,
            "--sidebar-width-icon": iconWidth,
            ...style,
          } as React.CSSProperties
        }
        {...props}
      >
        {children}
      </div>
    </SidebarContext.Provider>
  );
}

export default SidebarProvider;
