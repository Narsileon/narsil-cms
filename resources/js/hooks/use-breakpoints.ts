import { useMediaQuery } from "react-responsive";

export const breakpoints = {
  sm: 640,
  md: 768,
  lg: 1024,
  xl: 1280,
};

export const useMinSm = () => useMediaQuery({ minWidth: breakpoints.sm });
export const useMinMd = () => useMediaQuery({ minWidth: breakpoints.md });
export const useMinLg = () => useMediaQuery({ minWidth: breakpoints.lg });
export const useMinXl = () => useMediaQuery({ minWidth: breakpoints.xl });

export const useMaxXs = () => useMediaQuery({ maxWidth: breakpoints.sm - 1 });
export const useMaxSm = () => useMediaQuery({ maxWidth: breakpoints.md - 1 });
export const useMaxMd = () => useMediaQuery({ maxWidth: breakpoints.lg - 1 });
export const useMaxLg = () => useMediaQuery({ maxWidth: breakpoints.xl - 1 });
