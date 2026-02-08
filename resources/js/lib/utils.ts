import { concat, initial, toPath } from "lodash-es";

/**
 * Replace the last part of a path with a new value
 *
 * @param {string} path - the path to replace the last part of
 * @param {string} last - the new value to replace the last part of the path with
 *
 * @returns {string} the modified path
 */

export function replaceLastPath(path: string, last: string) {
  const parts = toPath(path);

  return concat(initial(parts), last).join(".");
}
