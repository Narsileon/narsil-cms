import { cn } from "@/lib/utils";
import { TooltipProvider } from "@/components/ui/tooltip";
import { useMaxLg } from "@/hooks/use-breakpoints";
import {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useMemo,
  useState,
} from "react";

export type SidebarProviderProps = React.ComponentProps<"div"> & {
  cookieMaxAge?: number;
  cookieName?: string;
  defaultOpen?: boolean;
  iconWidth?: string;
  keyboardShortcut?: string;
  mobileWidth?: string;
  open?: boolean;
  width?: string;
  onOpenChange?: (open: boolean) => void;
};

type SidebarContextProps = {
  isMobile: boolean;
  mobileWidth: string;
  open: boolean;
  openMobile: boolean;
  state: "expanded" | "collapsed";
  setOpen: (open: boolean) => void;
  setOpenMobile: (open: boolean) => void;
  toggleSidebar: () => void;
};

const SidebarContext = createContext<SidebarContextProps | null>(null);

function SidebarProvider({
  children,
  className,
  cookieMaxAge = 60 * 60 * 24 * 7,
  cookieName = "sidebar_state",
  defaultOpen = true,
  iconWidth = "3rem",
  keyboardShortcut = "b",
  mobileWidth = "18rem",
  onOpenChange: setOpenProp,
  open: openProp,
  style,
  width = "14rem",
  ...props
}: SidebarProviderProps) {
  const isMobile = useMaxLg();

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
    [
      isMobile,
      mobileWidth,
      open,
      openMobile,
      state,
      setOpen,
      setOpenMobile,
      toggleSidebar,
    ],
  );

  return (
    <SidebarContext.Provider value={contextValue}>
      <TooltipProvider delayDuration={0}>
        <div
          data-slot="sidebar-wrapper"
          className={cn(
            "group/sidebar-wrapper has-data-[variant=inset]:bg-sidebar flex min-h-svh w-full",
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
      </TooltipProvider>
    </SidebarContext.Provider>
  );
}

export function useSidebar() {
  const context = useContext(SidebarContext);

  if (!context) {
    throw new Error("useSidebar must be used within a SidebarProvider.");
  }

  return context;
}

export default SidebarProvider;
